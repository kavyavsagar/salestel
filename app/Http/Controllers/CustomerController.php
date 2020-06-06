<?php

namespace App\Http\Controllers;

use App\Customer;
use App\User;
use Illuminate\Http\Request;
use Redirect;
use DB;
use Validator,Response,File;
use App\Imports\CustomerImport;
use App\Imports\RetentionImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class CustomerController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:customer-list|customer-create|customer-edit|customer-delete',
            ['only' => ['index','show']]);
         $this->middleware('permission:customer-create', ['only' => ['create','store']]);
         $this->middleware('permission:customer-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:customer-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Team = [];
        
        array_push($Team, auth()->user()->id);

        if(auth()->user()->hasRole('Team Lead')){
            $tusers =  User::where('parentid', '=', auth()->user()->id)
                    ->get()
                    ->pluck('id')->toArray();

            array_push($Team, $tusers);
        }


        $query = DB::table('customers')
            ->join('users', 'users.id', '=', 'customers.refferedby')
            ->select('users.fullname', 'customers.*')
            ->where('customers.status', 1)
            ->orderBy('customers.id', 'DESC');

        if(auth()->user()->hasAnyRole('Agent', 'Team Lead')){           
            $query->whereIn('refferedby', $Team);
        }
        $data = $query->get();

        return view('customer.index',compact('data'));
    }

    public function pending(Request $request)
    {
        $Team = [];
        
        array_push($Team, auth()->user()->id);

        if(auth()->user()->hasRole('Team Lead')){
            $tusers =  User::where('parentid', '=', auth()->user()->id)
                    ->get()
                    ->pluck('id')->toArray();

            array_push($Team, $tusers);
        }


        $query = DB::table('customers')
            ->join('users', 'users.id', '=', 'customers.refferedby')
            ->select('users.fullname', 'customers.*')
            ->where('customers.status', 0)
            ->orderBy('customers.id', 'DESC');

        if(auth()->user()->hasAnyRole('Agent', 'Team Lead')){           
            $query->whereIn('refferedby', $Team);
        }
        $data = $query->get();

        return view('customer.pending',compact('data'));
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
        return view('customer.create',compact( 'users'));
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
            'company_name' => 'required',
            //'account_no' => 'required',
            'location' => 'required',
            'authority_name' => 'required',
            'authority_email' => 'required|email|unique:customers,authority_email',
            'authority_phone' => 'required',
            'technical_name' => 'required',
            'technical_email' => 'required|email',
            'technical_phone' => 'required',                
            'refferedby' => 'required',
            //'image' => 'required',
            'image.*' => 'file|image|mimes:jpeg,png,jpg,bmp,pdf|max:2048'         
        ]); 
        
        $input = $request->all();        
       
        $customer_id = $this->createCustomer($input, $request); 
               
        return redirect()->route('customer.index')
                        ->with('success','Customer created successfully');
    }


    // add customer details
    public function createCustomer($input, $request){
               
        // For Customers
        $cust_insert = [
            'company_name' => $input['company_name'],
            'account_no'   => $input['account_no'],
            'location'     => $input['location'],
            'authority_name' => $input['authority_name'],
            'authority_email' => $input['authority_email'],
            'authority_phone' => $input['authority_phone'],
            'technical_name' => $input['technical_name'],
            'technical_email' => $input['technical_email'],
            'technical_phone' => $input['technical_phone'],
            'refferedby' => $input['refferedby']? $input['refferedby'] : auth()->user()->id
        ];
     
        $customer = Customer::create($cust_insert);
        $insert = [];

        if ($request->hasfile('image')) {

            $saveTo = 'uploads/';
            $destinationPath = public_path().'/'.$saveTo; // upload path            

            foreach($request->file('image') as $files) {
              
                $image = $files->getClientOriginalName();

                $files->move($destinationPath, $image);

                $insert[] = array('customer_id' => $customer->id, 'document_path' => $saveTo.$image);                            
            }

            $check = DB::table('customer_documents')->insert($insert);
        }

        return $customer->id;
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
        $customer = DB::table('customers')
            ->join('users', 'users.id', '=', 'customers.refferedby')
            ->select('users.fullname', 'customers.*')
            ->where('customers.id', $id)
            ->first();

        $documents = DB::table('customer_documents')->where('customer_id',$id)->get()->pluck('document_path')->toArray();

        $orders = DB::table('orders')
            ->join('order_statuses AS os', 'os.id', '=', 'orders.order_status_id')
            ->join('order_plans AS op', 'op.order_id', '=', 'orders.id')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->select('os.name AS status', 'orders.total_amount', 'orders.created_at', 'orders.id', 'orders.plan_type', 'op.price', 'op.plan', 'op.quantity', 'op.plan_type AS ptype', 'op.total', 'op.phoneno')
            ->where('orders.customer_id', $id)
            ->orderBy('orders.id','DESC')
            ->get();
        

        return view('customer.show',compact('customer','documents', 'orders'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCustomer($id)
    {       
        //
        $customer = DB::table('customers')
                    ->where('account_no', '=', "{$id}")
                    ->orWhere('company_name', 'LIKE', "{$id}")
                    ->first();

        //Customer::where('account_no', '=', trim($id) )->first();

        return response()->json(['success'=>'Fetch customer successfully', 'customer' => json_encode($customer)]);
    }

    public function fetchCustomer(Request $request)
    {

        if($request->get('query') && strlen($request->get('query')) >2)
        {
            $query = $request->get('query');
            $data = DB::table('customers')
                    ->where('account_no', 'LIKE', "%{$query}%")
                    ->orWhere('company_name', 'LIKE', "%{$query}%")
                    ->get();

            $output = '<ul class="list-group auto-comp">';
            foreach($data as $row)
            {
               $output .= '<li class="list-group-item">'.$row->company_name.' <b>|</b> <span class="text-info">'.$row->account_no.'</span></li>';
            }
            $output .= '</ul>';
            echo $output;
        }
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
        $customer = Customer::find($id);

        $documents = DB::table('customer_documents')->where('customer_id',$id)->get()->pluck('document_path')->toArray();

        $users = User::all()->pluck('fullname', 'id')->toArray();  
    
        return view('customer.edit',compact('customer', 'users', 'documents'));
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
            'company_name' => 'required',
           // 'account_no'   => 'required',
            'location' => 'required',
            'authority_name' => 'required',
            'authority_email' => 'required|email|unique:customers,authority_email,'.$id,          
            'authority_phone' => 'required',
            'technical_name' => 'required',
            'technical_email' => 'required|email',
            'technical_phone' => 'required',                
            'refferedby' => 'required',
            //'image' => 'required',
            'image.*' => 'file|image|mimes:jpeg,png,jpg,bmp,pdf|max:2048' 
        ]);

        // $exists = Customer::where('authority_email',$input['authority_email'])
        //                     ->where('id', '<>' , $id)
        //                     ->count();

        //if(!$exists){
            $input = $request->all(); 
            $customerId = $this->updateCustomer($input, $request, $id);
        
            return redirect()->route('customer.index')
                        ->with('success','Customer updated successfully');   
        // }else{
            
        //     return back()->with('error','Customer already exists');  
        // }

        
    }


    /************ Update customer data ************/
    public function updateCustomer($input, $request, $id){

        // For Customers
        $cust_update = [
            'company_name' => $input['company_name'],
            'account_no'   => $input['account_no'],
            'location' => $input['location'],
            'authority_name' => $input['authority_name'],
            'authority_email' => $input['authority_email'],
            'authority_phone' => $input['authority_phone'],
            'technical_name' => $input['technical_name'],
            'technical_email' => $input['technical_email'],
            'technical_phone' => $input['technical_phone'],
            'refferedby' => $input['refferedby']? $input['refferedby'] : auth()->user()->id
        ];

        $customer = Customer::find($id);
        $customer->update($cust_update);

        $insert = [];
        
        if ($request->hasfile('image')) {

            $saveTo = 'uploads/';
            $destinationPath = public_path().'/'.$saveTo; // upload path            

            foreach ( $request->file('image') as $files) {
              
                $image = $files->getClientOriginalName();

                $files->move($destinationPath, $image);

                $insert[] = array('customer_id' => $id, 'document_path' => $saveTo.$image);                            
            }

            $check = DB::table('customer_documents')->insert($insert);
        }

        return $customer->id;
    }

    public function importView()
    {       

        return view('customer.import');
    }

    public function importExl(Request $request)
    {
       
        $validator = Validator::make(
          [
              'file'      => $request->file,
              'extension' => strtolower($request->file->getClientOriginalExtension()),
          ],
          [
              'file'      => 'required',
              'extension' => 'required|in:csv,xlsx,xls,ods',
          ]
        );
        $validHeaders = ['company', 'contactname', 'email', 'phone'];        
        $fileHeaders = current((new HeadingRowImport)->toArray($request->file('file'))[0]);
        $field = true; 
        foreach ($validHeaders as $i => $key) {
            if(!in_array($key, $fileHeaders)){ 
                $field = false; 
                break;
            }            
        } 

        if(!$field){
            $validator->after(function($validator) use($field) {            
                $validator->errors()->add('file', 'Please ensure proper headings to the excel [company, contactname, email, phone]');
               
            });
        }

        if ($validator->fails()) {
            return back()
                ->withErrors($validator);
        }

        try {
            Excel::import(new CustomerImport,$request->file('file'));            
        } catch (\Exception $e) {  
         
            $m = $e->getMessage();
            $dumb = ['Start row (2) is beyond highest row (1)'];
            if(in_array($m, $dumb)){ $m = 'Empty documents'; }
            
            return back()->with('error',$m);
        }
          
        return back()->with('success','Customer imported successfully');

    }

    public function importRetention(Request $request)
    {
       
        $validator = Validator::make(
          [
              'file'      => $request->file,
              'extension' => strtolower($request->file->getClientOriginalExtension()),
          ],
          [
              'file'         => 'required',
              'extension'    => 'required|in:doc,csv,xlsx,xls,ods',
          ]
        );
        // $fxdcols = ["be", "bc", "landline", "trunk", "isdn"];
        // $fileHeaders = current((new HeadingRowImport)->toArray($request->file('file'))[0]);       
     
        // $date = date('Y-m-d H:i:s');
        // $status = 0;
        // Plans and Prices
        // foreach ($fileHeaders as $key => $head) {
        //     $price = 0; $plan = ''; $type = '';

        //     $split = explode("_", $head);
        //     $len = count($split);
        //     $last = $split[$len-1];
  
        //     if($len >1 && preg_match('/^\d+$/', $last) ){
        //         $price = $split[$len-1];
        //         array_pop($split);
        //         $plan = implode(" ", $split);
        //         //$plan = ($len > 2)? implode(" ", $split): $head;

        //         foreach ($fxdcols as $col) {
        //             if (stripos(strtolower($plan), $col) !== false) {
        //                 $type = 'fixed';
        //             }else{
        //                 $type = 'mobile';
        //             }
        //         }

        //         $plExists = DB::table('plans')->where([
        //                         ['plan', '=', $plan],
        //                         ['plan_type', '=', $type]
        //                     ])->count();
        //         if(!$plExists){
        //             // insert plan
        //             $insertPlan = ["plan" => str_replace('_', ' ', $plan), 
        //                            "plan_type" => $type,
        //                            "created_at" => $date,
        //                            "updated_at" => $date,
        //                            "status" => $status
        //                         ];
        //             $planId = DB::table('plans')->insert($insertPlan);
        //         }

        //         $ifExists = DB::table('pricings')->where([
        //                         ['amount', '=', $price],
        //                         ['plan_type', '=', $type]
        //                     ])->count();

        //         if(!$ifExists){
        //         // insert price
        //             $insertPrice = ["amount" => $price, 
        //                            "plan_type" => $type,
        //                            "created_at" => $date,
        //                            "updated_at" => $date,
        //                            "status" => $status
        //                         ];
        //             $priceId = DB::table('pricings')->insert($insertPrice);
        //         }
        //     }else{
        //         continue;
        //     }

        // }
        

        try {
          Excel::import(new RetentionImport, $request->file('file'));            
    
        } catch (\Exception $e) {  
            $m = $e->getMessage();
            $dumb = ['Start row (2) is beyond highest row (1)'];
            if(in_array($m, $dumb)){ $m = 'Empty documents'; }
            
            return back()->with('error',$m);
        }
          
       

        return back()->with('success','Customer imported successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $docqry = DB::table('customer_documents')->where('customer_id',$id);
        $docObj = $docqry->get();

        $destinationPath = public_path().'/uploads/'; // upload path   
      
        foreach($docObj as $key => $doc) {            
            $image_path = $destinationPath.$doc->document_path;

            if(File::exists($image_path)) {
                File::delete($image_path);
            }
        }    

        $docqry->delete();

        Customer::find($id)->delete(); 

        return redirect()->route('customer.index')
                        ->with('success','Customer deleted successfully');
    }
}
