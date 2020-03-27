<?php

namespace App\Http\Controllers;

use App\Customer;
use App\User;
use Illuminate\Http\Request;
use Redirect;
use DB;
use Validator,Response,File;

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

        $data = DB::table('customers')
            ->join('users', 'users.id', '=', 'customers.refferedby')
            ->select('users.fullname', 'customers.*')
            ->paginate(15);

        return view('customer.index',compact('data'))
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
            'authority_name' => 'required',
            'authority_email' => 'required|email|unique:customers,authority_email',
            'authority_phone' => 'required',
            'technical_name' => 'required',
            'technical_email' => 'required|email',
            'technical_phone' => 'required',                
            'refferedby' => 'required',
            'image' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'             
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
            'location' => $input['location'],
            'authority_name' => $input['authority_name'],
            'authority_email' => $input['authority_email'],
            'authority_phone' => $input['authority_phone'],
            'technical_name' => $input['technical_name'],
            'technical_email' => $input['technical_email'],
            'technical_phone' => $input['technical_phone'],
            'refferedby' => $input['refferedby']
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

        return view('customer.show',compact('customer','documents'));
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
        $customer = Customer::find($id);

        return response()->json(['success'=>'Fetch customer successfully', 'customer' => json_encode($customer)]);
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
            'authority_name' => 'required',
            'authority_email' => 'required|email|unique:customers,authority_email,'.$id,              
            'authority_phone' => 'required',
            'technical_name' => 'required',
            'technical_email' => 'required|email',
            'technical_phone' => 'required',                
            'refferedby' => 'required',
            //'image' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'  
        ]);
    
        $input = $request->all(); 
        $customerId = $this->updateCustomer($input, $request, $id);
    
        return redirect()->route('customer.index')
                        ->with('success','Customer updated successfully');
    }


    /************ Update customer data ************/
    public function updateCustomer($input, $request, $id){

        // For Customers
        $cust_update = [
            'company_name' => $input['company_name'],
            'location' => $input['location'],
            'authority_name' => $input['authority_name'],
            'authority_email' => $input['authority_email'],
            'authority_phone' => $input['authority_phone'],
            'technical_name' => $input['technical_name'],
            'technical_email' => $input['technical_email'],
            'technical_phone' => $input['technical_phone'],
            'refferedby' => $input['refferedby']
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $docObj = DB::table('customer_documents')->where('customer_id',$id);
        $docObj = $docObj->get();

        $destinationPath = public_path().'/uploads/'; // upload path   
      
        foreach($docObj as $key => $doc) {            
            $image_path = $destinationPath.$doc->document_path;

            if(File::exists($image_path)) {
                File::delete($image_path);
            }
        }    

        DB::table('customer_documents')->delete();

        Customer::find($id)->delete(); 

        return redirect()->route('customer.index')
                        ->with('success','Customer deleted successfully');
    }
}
