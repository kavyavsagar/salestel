<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Complaint;
use App\User;
use Redirect;
use DB;
use Carbon\Carbon;
use Validator,Response,File;

class ComplaintController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:complaint-list|complaint-create|complaint-edit|complaint-delete',
            ['only' => ['index','show']]);
         $this->middleware('permission:complaint-create', ['only' => ['create','store']]);
         $this->middleware('permission:complaint-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:complaint-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
    {
        //  
        $Team = [];
        
        array_push($Team, auth()->user()->id);

        if(auth()->user()->hasRole('Team Lead')){
            $tusers =  User::where('parentid', '=', auth()->user()->id)
                    ->get()
                    ->pluck('id')->toArray();

            array_push($Team, $tusers);
        }

        $query = DB::table('complaints')
            ->join('users AS u1', 'u1.id', '=', 'complaints.reported_by')
            ->join('complaint_statuses AS cs', 'cs.id', '=', 'complaints.status')
            ->select('u1.fullname', 'cs.name as status_name', 'complaints.*');
       
        if(auth()->user()->hasAnyRole('Agent', 'Team Lead')){           
            $query->whereIn('complaints.reported_by', $Team);
        }
        $data = $query->paginate(25)->appends(request()->query());            

        return view('complaint.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $users = User::all()->pluck('fullname', 'id')->toArray();        
        return view('complaint.create',compact( 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $this->validate($request, [
            'customer_acc_no' => 'required',
            'description'   => 'required',
            'priority' => 'required',
            'reported_by' => 'required', 
            'filepath' => 'file|image|mimes:jpeg,png,jpg,bmp,pdf|max:2048'    
        ]); 
        
        $input = $request->all();

        if ($request->hasfile('filepath')) {

            $saveTo = 'uploads/complaints';
            $destinationPath = public_path().'/'.$saveTo; // upload path  
            $files = $request->file('filepath');          
            
            $image = $files->getClientOriginalName();

            $files->move($destinationPath, $image);

            $input['filepath'] = $saveTo.'/'.$image;
            
        }      
        $complaint = Complaint::create($input);

        $history = [
            'complaint_id' => $complaint->id,
            'status_id' => 1,
            'comment'   => 'Reported new complaint of customer '.$input['customer_acc_no'],
            'added_by' => auth()->user()->id,
            'created_at'  => \Carbon\Carbon::now(), # new \Datetime()
            'updated_at'  => \Carbon\Carbon::now()  # new \Datetime()
        ];
        DB::table('complaint_histories')->insert($history);
               
        return redirect()->route('complaint.index')
                        ->with('success','Complaint created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        //$complaint = Complaint::find($id);

        $complaint = DB::table('complaints')
            ->join('users AS u1', 'u1.id', '=', 'complaints.reported_by')
            ->join('complaint_statuses AS cs', 'cs.id', '=', 'complaints.status')
            ->select('u1.fullname', 'cs.name AS status_name', 'complaints.*')
            ->where('complaints.id', $id)
            ->first();
 
        $statuses = DB::table('complaint_statuses')->get();
  
        $histories = DB::table('complaint_histories As ch')
                    ->join('users AS u1', 'u1.id', '=', 'ch.added_by')
                    ->join('complaint_statuses AS cs', 'cs.id', '=', 'ch.status_id')
                    ->select('u1.fullname', 'cs.name AS status_name', 'ch.*')
                    ->where('complaint_id', $id)
                    ->orderBy('created_at', 'DESC')
                    ->get();

    
        return view('complaint.show',compact('complaint', 'statuses', 'histories'));
    }

    // Change the order status
    public function changeStatus(Request $request){
        
        $this->validate($request, [      
            'complaintid'   => 'required',
            'status' => 'required',
            'comment' => 'required'     
        ]); 

        $input = $request->all();       
        $complaint = Complaint::find($input['complaintid']);
        $old_status = $complaint->status;

        if($old_status != $input['status']){

            $update = [                       
                'status' => $input['status']
            ];
            ## Update complaint
            $complaint->update($update);

            // add history
            $history = [
                'complaint_id' => $input['complaintid'],
                'status_id' =>  $input['status'],
                'comment'   => $input['comment']?$input['comment']: '',
                'added_by'  => auth()->user()->id,
                'created_at'  => \Carbon\Carbon::now(), # new \Datetime()
                'updated_at'  => \Carbon\Carbon::now()  # new \Datetime()
            ];
            DB::table('complaint_histories')->insert($history);
        }else{
            return back()->with('error','You should select right status');
        }

        return redirect()->route('complaint.show', $complaint->id)
                        ->with('success','Complaint status updated successfully');

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
        $complaint = Complaint::find($id);
        $users = User::all()->pluck('fullname', 'id')->toArray(); 
    
        return view('complaint.edit',compact('complaint', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'customer_acc_no' => 'required',
            'description' => 'required',
            'priority' => 'required',
            'reported_by' => 'required', 
            'filepath' => 'file|image|mimes:jpeg,png,jpg,bmp,pdf|max:2048'               
        ]); 
        
        $input = $request->all();

        $complaint = Complaint::find($id);
        $oldfile = $complaint->filepath? $complaint->filepath : false;

        if ($request->hasfile('filepath')) {          

            $saveTo = 'uploads/complaints';
            $destinationPath = public_path().'/'.$saveTo; // upload path  
            $files = $request->file('filepath');          
            
            $image = $files->getClientOriginalName();

            $files->move($destinationPath, $image);

            $input['filepath'] = $saveTo.'/'.$image;
            if($oldfile){   
                // old file deleted
                $image_path = public_path().'/'.$oldfile; // upload path  

                if(File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            
        }
        
        $complaint->update($input);
               
        return redirect()->route('complaint.index')
                        ->with('success','Complaint updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        // Complaint Status history
        DB::table('complaint_histories')->where('complaint_id',$id)->delete();

        // Complaint
        $complaint = Complaint::find($id);        
        
        if($complaint->filepath != ''){   
            //  file deleted             
            $image_path = public_path().'/'. $complaint->filepath; // upload path  

            if(File::exists($image_path)) {
                File::delete($image_path);
            }
        }        

        $complaint->delete(); 

        return redirect()->route('complaint.index')
                        ->with('success','Complaint deleted successfully');
    }
}
