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
use App\OrderStatus;
use App\Order;
use App\Exports\OrderExport;

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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        $input = $request->all();

        // Users
        $arUser = User::all()->toArray();        

        $Team = [];       

        $tusers = []; $users =[]; $unique_parent =[];
        foreach ($arUser as $key => $us) {
      
            $users[$us['id']] =  $us['fullname'];

            // get unique parent ids
            if($us['parentid'] !=0 && !in_array($us['parentid'], $unique_parent)){
                $unique_parent[$us['parentid']] = $us['parentid'];
            }
            // For getting teams of login team lead
            if($us['parentid'] == auth()->user()->id || 
                (isset($input['parentid']) && $input['parentid'] == $us['parentid'])){               
                array_push($tusers, $us['id']);
            }
        }

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
        $custIds = [];

        if(!empty($Team)){
            $custIds = DB::table('customers')->whereIn('customers.refferedby', $Team)
                    ->get()
                    ->pluck('id')->toArray();
        }

        $query = DB::table('orders')
            ->join('order_statuses', 'order_statuses.id', '=', 'orders.order_status_id')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('users', 'users.id', '=', 'customers.refferedby')
            ->select('order_statuses.name AS status','customers.company_name', 'customers.account_no',  'users.fullname', 'orders.sales_priority', 'orders.total_amount', 'orders.exp_closing_date', 'orders.created_at', 'orders.id', 'orders.plan_type')
            ->where('orders.order_status_id','=', 14);  // initial
        
        if(!empty($custIds)){ 
            // condition applied for search by parent or team lead/agent login or search by user
            $query->whereIn('orders.customer_id', $custIds);    
        }
        
        if(isset($input['start_date']) && $input['start_date'] != ""
            && isset($input['end_date']) && $input['end_date'] != ""){  // Search by dates
            
            $from =  new Carbon($input['start_date']);           
            $to =   new Carbon($input['end_date']);
            
           $query->whereBetween('orders.created_at', array($from.'.000000', $to->endOfDay().'.000000' ));          
        }

        $query->orderBy('orders.id', 'DESC');
        $data = $query->paginate(10);

        $fields = $input;
        
        return view('dsr.index',compact('data', 'users', 'unique_parent', 'fields'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }
    
    public function exportCSV(Request $request)
    {   

        $input = $request->all();

        $date = now();
        return Excel::download(new OrderExport($input), 'order'.$date.'.xlsx');
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $mob_prices = Pricing::orderBy('amount','ASC')->where('plan_type', 'mobile')->get()
                    ->pluck('amount', 'id')->toArray();

        $fxd_prices = Pricing::orderBy('amount','ASC')->where('plan_type', 'fixed')->get()
                    ->pluck('amount', 'id')->toArray();

        $mob_plans = Plan::orderBy('plan','ASC')->where('plan_type', 'mobile')->get()
                    ->pluck('plan', 'id')->toArray();

        $fxd_plans = Plan::orderBy('plan','ASC')->where('plan_type', 'fixed')->get()
                    ->pluck('plan', 'id')->toArray();
        

        $users = User::all()->pluck('fullname', 'id')->toArray(); 

        $customers = Customer::all()->pluck('company_name', 'id')->toArray(); 


        return view('dsr.create',compact('users', 'customers', 'mob_prices', 'fxd_prices', 'mob_plans', 'fxd_plans'));

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
            'company_name' => 'required',
            'account_no' => 'required',
            'authority_name' => 'required',          
            'authority_phone' => 'required',
            'technical_name' => 'required',
            'technical_email' => 'required|email',
            'technical_phone' => 'required',                
            'refferedby' => 'required',
            //'image' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'order_status' => 'required',
            'sales_priority' => 'required'
        ]); 

        $input = $request->all();

        if(isset($input['customerid']) && $input['customerid'] !=0){
            //update customer
            $cid = $input['customerid'];
            $this->validate($request, [
                'authority_email' => 'required|email|unique:customers,authority_email,'.$cid, 
                ]);
            $input['customer_id'] = app(CustomerController::class)->updateCustomer($input, $request, $cid);
             
        }else{
            // Create Customer
            $this->validate($request, [
                'authority_email' => 'required|email|unique:customers,authority_email'
                ]);
            $input['customer_id'] = app(CustomerController::class)->createCustomer($input, $request); 
        }     

        // For MOBILE
        if(isset($input['mobile']) && $input['mobile']){  
            $input['mobile'] = json_decode($input['mobile']);  

            $res_m = $this->insertOrderPlan($input, 'mobile');
        }

        // For FIXED
        if(isset($input['fixed']) && $input['fixed']){
            $input['fixed'] = json_decode($input['fixed']);    

            $res_f = $this->insertOrderPlan($input, 'fixed');
        }
        
        if($res_m || $res_f){
            return response()->json(['success'=>'You have successfully placed an order.']);
        }
        return response()->json(['error'=>'There is an error occured while placing an order.']);
        
    }

    // place mobile/fixed orders with plans and status
    public function insertOrderPlan($input, $ikey){

        $order_insert = [];  $status_insert = [];  $plan_insert = [];

        $order_insert['customer_id'] = $input['customer_id'];
        $order_insert['order_status_id'] = $input['order_status']; 
        $order_insert['sales_priority'] = $input['sales_priority'];       

        // first order for MOBILE  /FIXED      
        $total = 0;
        foreach ($input[$ikey] as $key => $arplan) { 

            $total += $arplan->total;
            $plan_insert[] = [
                            "order_id"   => 0,
                            "price"      => $arplan->price,
                            "plan"       => $arplan->plan,
                            "plan_id"    => $arplan->planid,
                            "plan_type"  => $arplan->plan_type,    
                            "quantity"   => $arplan->qty,
                            "total"      => $arplan->total,
                            "created_at" => \Carbon\Carbon::now(), # new \Datetime()
                            "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
                        ];   
        }
        $order_insert['plan_type'] = $ikey;
        $order_insert['total_amount'] = $total;

        if(isset($input[$ikey.'_eclosing_date']) && $input[$ikey.'_eclosing_date'] != ''){            
            $cdate = str_replace('/', '-', $input[$ikey.'_eclosing_date']);            
            $order_insert['exp_closing_date'] = date("Y-m-d", strtotime($cdate)); 
        }
        if(isset($input[$ikey.'_erevenue']) && $input[$ikey.'_erevenue'] != ''){
            $order_insert['exp_revenue'] = $input[$ikey.'_erevenue']; 
        }


        #### Order Insert
        $order = Order::create($order_insert); 


        #### Order Status History
        $status_insert = [
                    "order_id"        => $order->id,
                    "order_status_id" => $input['order_status'],
                    "comments"        => $input['comments'],
                    "added_by"        => auth()->user()->id,
                    "created_at"      => \Carbon\Carbon::now(), # new \Datetime()
                    "updated_at"      => \Carbon\Carbon::now()  # new \Datetime()
                    ];

        DB::table('order_historys')->insert($status_insert);


        #### Order Plans
        foreach ($plan_insert as $pk => $plans) { 
            $plan_insert[$pk]["order_id"]  = $order->id;
        }

        DB::table('order_plans')->insert($plan_insert);

        return true;
    }

    // update fixed/mobile orders with plans and status
    public function updateOrderPlan($input, $orderid){

        $order_insert = [];  $status_insert = [];  $plan_insert = [];

        // second order for FIXED/MOBILE       1 
        $total = 0;
        foreach ($input['order_plan'] as $key => $arplan) {
            if(isset($arplan->isdelete) && $arplan->isdelete == 1){
                //delete this plan
                DB::table('order_plans')->where('id', $arplan->order_planid)->delete();
                continue;
            }

            if(isset($arplan->order_planid) && $arplan->order_planid){
                // edit existing plan
            }else{
                $plan_insert[] = [
                    "order_id"   => $orderid,
                    "price"      => $arplan->price,
                    "plan"       => $arplan->plan,
                    "plan_id"    => $arplan->planid,
                    "plan_type"  => $arplan->plan_type,    
                    "quantity"   => $arplan->qty,
                    "total"      => $arplan->total,
                    "created_at" => \Carbon\Carbon::now(), # new \Datetime()
                    "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
                ];

            }            
            $total += $arplan->total;
               
        }        
        #### Order Plans       
        DB::table('order_plans')->insert($plan_insert);


        #### Order Update   
        $order = Order::find($orderid);
        $old_order_status = $order->order_status_id;

        $order_insert['total_amount'] = $total;
        $order_insert['customer_id'] = $input['customer_id'];

        if($old_order_status != $input['order_status']){
            // current status not match with previous one
            $order_insert['order_status_id'] = $input['order_status'];

            #### Order Status History
            $status_insert = [
                        "order_id"        => $order->id,
                        "order_status_id" => $input['order_status'],
                        "comments"        => $input['comments'],
                        "activity_no"     => $input['activity_no'],
                        "added_by"        => auth()->user()->id,
                        "created_at"      => \Carbon\Carbon::now(), # new \Datetime()
                        "updated_at"      => \Carbon\Carbon::now()  # new \Datetime()
                        ];

            DB::table('order_historys')->insert($status_insert);

        }
        $ikey = $order->plan_type;

        if(isset($input[$ikey.'_eclosing_date']) && $input[$ikey.'_eclosing_date'] != ''){            
            $cdate = str_replace('/', '-', $input[$ikey.'_eclosing_date']);
            $order_insert['exp_closing_date'] = date("Y-m-d", strtotime($cdate)); 
        }
        if(isset($input[$ikey.'_erevenue']) && $input[$ikey.'_erevenue'] != ''){
            $order_insert['exp_revenue'] = $input[$ikey.'_erevenue']; 
        }
      
        // Order Updation    
        $res = $order->update($order_insert);

        return $res;
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
        $order = DB::table('orders AS or')            
            ->join('customers AS ct', 'ct.id', '=', 'or.customer_id')
            ->join('users AS us', 'us.id', '=', 'ct.refferedby')
            ->select('us.fullname', 'ct.company_name', 'ct.account_no', 'ct.location','ct.authority_name','ct.authority_email','ct.authority_phone','ct.technical_name','ct.technical_email','ct.technical_phone',
                'or.total_amount','or.created_at', 'or.id', 'or.plan_type', 'or.customer_id', 'or.order_status_id', 'or.activation_date', 'or.sales_priority','or.exp_revenue','or.exp_closing_date')         
            ->where('or.id', $id)
            ->first();

        $documents = DB::table('customer_documents')->where('customer_id',$order->customer_id)->get()->pluck('document_path')->toArray();

        $ord_plans = DB::table('order_plans AS op')
                    ->select('op.price', 'op.plan', 'op.quantity', 'op.plan_type', 'op.total')   
                    ->where('op.order_id',$id)
                    ->get();

        $ord_history = DB::table('order_historys AS oh')
                    ->orderBy('oh.id','DESC')
                    ->join('order_statuses AS os', 'os.id', '=', 'oh.order_status_id')
                    ->join('users AS us', 'us.id', '=', 'oh.added_by')
                    ->select('os.name', 'oh.comments','oh.activity_no', 'oh.created_at','us.fullname')   
                    ->where('oh.order_id',$id)
                    ->get();
        
        $ordstatus = OrderStatus::orderBy('id','ASC')->get()
                    ->pluck('name', 'id')->toArray();                    


        return view('dsr.show',compact('order','documents', 'ord_plans', 'ord_history', 'ordstatus'));
    }

    // Change the order status
    public function changeStatus(Request $request){
        
        $this->validate($request, [      
            'orderid'   => 'required'    
        ]); 

        $input = $request->all();

        // To open orders
        $statusid = 1; // 
        $update = [];
        $order = Order::find($input['orderid']);
        $update['order_status_id'] = $statusid;

        $oldorderstatus = $order->order_status_id;
        if($oldorderstatus != $statusid){
            
            #### Order Status History
            $status_insert = [
                        "order_id"        => $input['orderid'],
                        "order_status_id" => $statusid,
                        "comments"        => 'DSR is activated as an order',
                        "activity_no"     => '',                    
                        "added_by"        => auth()->user()->id,
                        "created_at"      => \Carbon\Carbon::now(), # new \Datetime()
                        "updated_at"      => \Carbon\Carbon::now()  # new \Datetime()
                        ];

            DB::table('order_historys')->insert($status_insert);
        }

        ## Update Order
        $order->update($update);

        return response()->json(['success'=>'DSR activated as an order successfully']);

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
        $order = Order::find($id);

        $mob_prices = Pricing::orderBy('amount','ASC')->where('plan_type', 'mobile')->get()
                    ->pluck('amount', 'id')->toArray();

        $fxd_prices = Pricing::orderBy('amount','ASC')->where('plan_type', 'fixed')->get()
                    ->pluck('amount', 'id')->toArray();

        $mob_plans = Plan::orderBy('plan','ASC')->where('plan_type', 'mobile')->get()
                    ->pluck('plan', 'id')->toArray();

        $fxd_plans = Plan::orderBy('plan','ASC')->where('plan_type', 'fixed')->get()
                    ->pluck('plan', 'id')->toArray();

        $users = User::all()->pluck('fullname', 'id')->toArray(); 

        $customerList = Customer::all()->pluck('company_name', 'id')->toArray(); 

        $customer = Customer::find($order->customer_id);

        $documents = DB::table('customer_documents')->where('customer_id',$order->customer_id)->get()->pluck('document_path')->toArray();

        $arplans = DB::table('order_plans')
                    ->select('price', 'plan', 'plan_id','plan_type', 'quantity', 'total', 'id AS order_planid')
                    ->where('order_id',$id)->get();
        
        $history = DB::table('order_historys AS oh')
                    ->orderBy('oh.id','DESC')
                    ->join('order_statuses AS os', 'os.id', '=', 'oh.order_status_id')
                    ->join('users AS us', 'us.id', '=', 'oh.added_by')
                    ->select('os.name', 'oh.comments', 'oh.activity_no', 'oh.order_status_id', 'oh.created_at', 'us.fullname')   
                    ->where('oh.order_id',$id)
                    ->get();
    
        return view('dsr.edit',compact('customer', 'users','order', 'documents', 'customerList', 'mob_prices', 'fxd_prices', 'mob_plans', 'fxd_plans',  'arplans', 'history'));

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
            'orderid'   => 'required',
            'company_name' => 'required',
            'account_no' => 'required',
            'authority_name' => 'required',          
            'authority_phone' => 'required',
            'technical_name' => 'required',
            'technical_email' => 'required|email',
            'technical_phone' => 'required',                
            'refferedby' => 'required',
            //'image' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'order_status' => 'required',
            'sales_priority' => 'required'
        ]); 

        $input = $request->all();

        $id = $input['orderid'];

        // For CUSTOMER
        if(isset($input['customerid']) && $input['customerid'] !=0){
            //update customer
            $cid = $input['customerid'];
            $this->validate($request, [
                'authority_email' => 'required|email|unique:customers,authority_email,'.$cid, 
                ]);
            $input['customer_id'] = app(CustomerController::class)->updateCustomer($input, $request, $cid);
             
        }else{
            // Create Customer
            $this->validate($request, [
                'authority_email' => 'required|email|unique:customers,authority_email'
                ]);
            $input['customer_id'] = app(CustomerController::class)->createCustomer($input, $request); 
        }   

        // For MOBILE ORDER
        $mobile = json_decode($input['mobile']);
        // For FIXED ORDER
        $fixed = json_decode($input['fixed']);

        if(!empty($mobile)){
            $input['order_plan'] = $mobile;

        }elseif(!empty($fixed)){
            $input['order_plan'] = $fixed;
        }

        $res = $this->updateOrderPlan($input, $id);
        
        if($res){
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
        DB::table('order_plans')->where('order_id',$id)->delete();

        // Order Status history
        DB::table('order_historys')->where('order_id',$id)->delete();

        // Order
        Order::find($id)->delete(); 

        return redirect()->route('dsr.index')
                        ->with('success','DSR deleted successfully');
    }
}
