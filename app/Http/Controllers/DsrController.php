<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Controllers\CustomerController;
use Redirect;
use Validator,Response;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

// Models
use DB;
use App\User;
use App\Customer;
use App\Pricing;
use App\Plan;
use App\PlanStatus;
use App\OrderStatus;
use App\Order;
use App\Exports\DsrExport;

use App\Dsr;
use App\DsrStatus;

class DsrController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:dsr-list|dsr-create|dsr-edit|dsr-delete',
            ['only' => ['index','show']]);
         $this->middleware('permission:dsr-create', ['only' => ['create','store']]);
         $this->middleware('permission:dsr-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:dsr-delete', ['only' => ['destroy']]);
    } 
    /********** Export **************
    */
    public function exportCSV(Request $request)
    {   

        $input = $request->all();

        $date = now();
        return Excel::download(new DsrExport($input), 'DSR'.$date.'.xlsx');
    }   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        $input = $request->all();

        $dsrstatus = DB::table('dsr_statuses')->orderBy('id', 'ASC')                   
                    ->get()
                    ->pluck('name', 'id')->toArray();

        // Users
        $arUser = User::where('status', '1')->orderBy('fullname', 'ASC')->get()->toArray();        

        $Team = [];       

        $tusers = []; $users =[]; $unique_parent =[];
        foreach ($arUser as $key => $us) {
      
            if(auth()->user()->hasAnyRole(['Coordinator', 'Admin'])) { 
                // admin, coordinator
                $users[$us['id']] =  $us['fullname'];
            }


            // get unique parent ids
            if($us['parentid'] !=0 && !in_array($us['parentid'], $unique_parent)){
                $unique_parent[$us['parentid']] = $us['parentid'];
            }
            // For getting teams of login team lead
            if($us['parentid'] == auth()->user()->id || 
                (isset($input['parentid']) && $input['parentid'] == $us['parentid'])){               
                array_push($tusers, $us['id']);
                $users[$us['id']] =  $us['fullname'];
            }
        }//
        

        if(isset($input['parentid']) && $input['parentid'] !=0 ){   // search by team
            array_push($Team, $input['parentid']); 
            $Team = array_merge($Team, $tusers);

        }else if(isset($input['userid']) && $input['userid'] !=0 ){  // search by user
            array_push($Team, $input['userid']); 

        }else if(auth()->user()->hasAnyRole('Agent', 'Team Lead')){           
            array_push($Team, auth()->user()->id);  // for agent and team lead           

            if(auth()->user()->hasRole('Team Lead')) {  // for merging team with team lead
                $Team = array_merge($Team, $tusers);
            } 
        }       

        $query = DB::table('dsrs as dsr')  
            ->join('users as u', 'u.id', '=', 'dsr.refferedby')  
            ->join('dsr_statuses as st', 'st.id', '=', 'dsr.dsr_status')          
            ->select('dsr.*', 'u.fullname', 'st.name as status'); // initial
             
        if(!empty($Team)){ 
          
            // condition applied for search by parent or team lead/agent login or search by user
            $query->whereIn('dsr.refferedby', $Team);    
        }else{
            if( (isset($input['parentid']) && $input['parentid'] >0) || 
                (isset($input['userid']) && $input['userid'] >0) ) { 
                $query->where('dsr.refferedby', 0); 
            }
        }  

        if(isset($input['dsr_status']) && $input['dsr_status']){
            $query->where('dsr.dsr_status', '=', $input['dsr_status']); 
        }

        if(isset($input['start_date']) && $input['start_date'] != ""
            && isset($input['end_date']) && $input['end_date'] != ""){  // Search by dates
            
            $from =  new Carbon($input['start_date']);           
            $to =   new Carbon($input['end_date']);
            
           $query->whereBetween('dsr.updated_at', array($from.'.000000', $to->endOfDay().'.000000' ));          
        }

        $query->orderBy('dsr.id', 'DESC');
        $data = $query->paginate(100)->appends(request()->query());

        $fields = $input;

        return view('dsr.index',compact('data', 'users', 'unique_parent', 'fields', 'dsrstatus'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }
        
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //        
        $dsrStatus = DsrStatus::orderBy('id','ASC')->get()
                        ->pluck('name', 'id')->toArray();

        return view('dsr.create',compact('dsrStatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {     

        $this->validate($request, [
            'company' => 'required',
        //    'contact_name' => 'required',          
            'phone' => 'required',          
        //    'email' => 'email', //required|
        //    'remarks' => 'required',                
            'refferedby' => 'required',
            'dsr_status' => 'required'
        ]); 

        $input = $request->all();

        $dsrInsert = [
            'company'       => $input['company'],
            'location'      =>  $input['location'],
            'contact_name'  => $input['contact_name'],        
            'phone'         => $input['phone'],       
            'email'         => $input['email'],
            'remarks'       => $input['remarks'],      
            'refferedby'    => $input['refferedby'],
            'dsr_status'    => $input['dsr_status'],
        ];

        $dsrInsert = $input;
        if(isset($input['reminder_date'])){
            $dsrInsert['reminder_date'] = date("Y-m-d H:i:s", strtotime($input['reminder_date']));
        }
        if(isset($input['expected_closing'])){
            $dsrInsert['expected_closing'] = date("Y-m-d", strtotime($input['expected_closing']));
        }

        $dsr = Dsr::create($dsrInsert);

        $res_m = '';
        // For MOBILE
        $input['plandetails'] = json_decode($input['plandetails']); 
        if(isset($input['plandetails']) && !empty($input['plandetails']) ){               

            $res_m = $this->insertDsrPlan($input, $dsr->id);
        }

    
        if($dsr || $res_m){
            return response()->json(['success'=>'You have successfully placed a DSR.']);
        }
        return response()->json(['error'=>'There is an error occured while placing a DSR.']);
        
    }

    // place mobile/fixed orders with plans and status
    public function insertDsrPlan($input, $dsrid){

        $plan_insert = [];       

        // first order for MOBILE  /FIXED            
        foreach ($input['plandetails'] as $key => $arplan) { 

            $plan_insert[] = [
                            "dsr_id"     => $dsrid,
                            "price"      => $arplan->price,
                            "plan"       => $arplan->plan,                           
                            "plan_type"  => $arplan->plan_type,    
                            "quantity"   => $arplan->qty,
                            "created_at" => \Carbon\Carbon::now(), # new \Datetime()
                            "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
                        ];   
        }
       
        #### Order Plans
        DB::table('dsr_plans')->insert($plan_insert);

        return true;
    }

    // update fixed/mobile orders with plans and status
    public function updateDsrPlan($input, $dsrid){

        $plan_insert = [];  
       // dd($input['plandetails']);     

        // first order for MOBILE  /FIXED            
        foreach ($input['plandetails'] as $key => $arplan) { 
            if(isset($arplan->isdelete) && $arplan->isdelete == 1){
                //delete this plan
                DB::table('dsr_plans')->where('id', $arplan->id)->delete();
                continue;
            }
            if(isset($arplan->id) && $arplan->id){
                // edit existing plan
            }else{

                $plan_insert[] = [
                            "dsr_id"     => $dsrid,
                            "price"      => $arplan->price,
                            "plan"       => $arplan->plan,                           
                            "plan_type"  => $arplan->plan_type,    
                            "quantity"   => $arplan->qty,
                            "created_at" => \Carbon\Carbon::now(), # new \Datetime()
                            "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
                        ]; 
            }  
        }
       
        #### Order Plans
        DB::table('dsr_plans')->insert($plan_insert);

        return true;     
    }    


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $dsrStatus = DsrStatus::orderBy('id','ASC')->get()
                        ->pluck('name', 'id')->toArray();

        $dsr = DB::table('dsrs as d')
                    ->join('dsr_statuses AS ds', 'ds.id', '=', 'd.dsr_status')
                    ->select('d.*', 'ds.name as status')
                    ->where('d.id',$id)->first();

        $arplans = DB::table('dsr_plans')
                    ->select('*')
                    ->where('dsr_id',$id)->get();
        
     
    
        return view('dsr.edit',compact('dsrStatus', 'dsr', 'arplans'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'dsrid'   => 'required',
            'company' => 'required',
        //    'contact_name' => 'required',          
            'phone' => 'required',          
          //  'email' => 'email', //required|
            'remarks' => 'required',                
            'refferedby' => 'required',
            'dsr_status' => 'required'
        ]); 

        $input = $request->all();
        $id = $input['dsrid'];

        $dsrInsert = [
            'company'       => $input['company'],
            'location'      => $input['location'],
            'contact_name'  => $input['contact_name'],        
            'phone'         => $input['phone'],       
            'email'         => $input['email'],
            'remarks'       => $input['remarks'],      
            'refferedby'    => $input['refferedby'],
            'dsr_status'    => $input['dsr_status'],
        ];

        $dsrInsert = $input;
        if(isset($input['reminder_date'])){
            $dsrInsert['reminder_date'] = date("Y-m-d H:i:s", strtotime($input['reminder_date']));
        }
        if(isset($input['expected_closing'])){
            $dsrInsert['expected_closing'] = date("Y-m-d", strtotime($input['expected_closing']));
        }
        $dsr = Dsr::find($id);
        $dsr->update($dsrInsert);
         
        $res_m = '';
        // For MOBILE
        $input['plandetails'] = json_decode($input['plandetails']); 
        if(isset($input['plandetails']) && !empty($input['plandetails']) ){               

            $res_m = $this->updateDsrPlan($input, $id);
        }
        
        if($dsr || $res_m){
            return response()->json(['success'=>'You have successfully updated an order.']);
        }
        
        return response()->json(['error'=>'There is an error occured while updating an order.']);        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        // Order Plans
        DB::table('dsr_plans')->where('dsr_id',$id)->delete();

        // Order
        Dsr::find($id)->delete(); 

        return redirect()->route('dsr.index')
                        ->with('success','DSR deleted successfully');
    }
}
