<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use DB;
use App\User;
use App\Customer;
use App\OrderStatus;
use App\Order;
use App\Complaint;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $neworders = $this->newOrders();
       
        $leads = $this->leadOrders();
        
        $duapprove = $this->duApprovedOrders();

        $createdords = $this->createdOrders();

        $deliveryords = $this->deliveryOrders();

        $comporders = $this->completedOrders();

        $docRejected = $this->docRejectedOrders();

        $markRejected = $this->markFailedOrders();

        $duRejected = $this->duRejectedOrders();

        $rejectedords = $this->rejectedOrders();


        $flag = false; // for admin & coordinator
        if(auth()->user()->hasAnyRole('Agent', 'Team Lead')){           
           $flag = true;
        }

        $customers = count($this->getCustomers($flag));

        $complaints = $this->pendingComplaints();

        return view('home', compact('neworders', 'leads','duapprove','createdords','deliveryords', 'comporders','docRejected','markRejected','duRejected', 'rejectedords', 'customers', 'complaints') );

    }
    public function newOrders(){

        $custIds = $this->getCustomers();

        $query = Order::where('order_status_id', 1);

        if(!empty($custIds)){ 
            // condition applied for search by parent or team lead/agent login or search by user
            $query->whereIn('orders.customer_id', $custIds);    
        }       

        $count = $query->count();

        return $count;
    }
    public function completedOrders(){

        $custIds = $this->getCustomers();

        $query = Order::where('order_status_id', 13);

        if(!empty($custIds)){ 
            // condition applied for search by parent or team lead/agent login or search by user
            $query->whereIn('orders.customer_id', $custIds);    
        }       

        $count = $query->count();
        $total = $query->sum('total_amount');

        $res = ["count" => $count, "total" => $total];

        return $res;
    }
    public function leadOrders(){

        $custIds = $this->getCustomers();

        $query = Order::whereIn('order_status_id', [2,4,6]);

        if(!empty($custIds)){ 
            // condition applied for search by parent or team lead/agent login or search by user
            $query->whereIn('orders.customer_id', $custIds);    
        }       

        $count = $query->count();

        return $count;
    }
    public function duApprovedOrders(){

        $custIds = $this->getCustomers();

        $query = Order::where('order_status_id', 7);

        if(!empty($custIds)){ 
            // condition applied for search by parent or team lead/agent login or search by user
            $query->whereIn('orders.customer_id', $custIds);    
        }       

        $count = $query->count();

        return $count;
    }
    public function createdOrders(){

        $custIds = $this->getCustomers();

        $query = Order::where('order_status_id', 9);

        if(!empty($custIds)){ 
            // condition applied for search by parent or team lead/agent login or search by user
            $query->whereIn('orders.customer_id', $custIds);    
        }       

        $count = $query->count();

        return $count;
    }
    public function deliveryOrders(){

        $custIds = $this->getCustomers();

        $query = Order::whereIn('order_status_id', [11,12]);

        if(!empty($custIds)){ 
            // condition applied for search by parent or team lead/agent login or search by user
            $query->whereIn('orders.customer_id', $custIds);    
        }       

        $count = $query->count();

        return $count;
    }
    public function docRejectedOrders()
    {

        $custIds = $this->getCustomers();

        $query = Order::where('order_status_id', 3);

        if(!empty($custIds)){ 
            // condition applied for search by parent or team lead/agent login or search by user
            $query->whereIn('orders.customer_id', $custIds);    
        }
        $count = $query->count();

        return $count;
    }
    public function markFailedOrders()
    {

        $custIds = $this->getCustomers();

        $query = Order::where('order_status_id', 5);

        if(!empty($custIds)){ 
            // condition applied for search by parent or team lead/agent login or search by user
            $query->whereIn('orders.customer_id', $custIds);    
        }
        $count = $query->count();

        return $count;
    }
    public function duRejectedOrders()
    {

        $custIds = $this->getCustomers();

        $query = Order::where('order_status_id', 8);

        if(!empty($custIds)){ 
            // condition applied for search by parent or team lead/agent login or search by user
            $query->whereIn('orders.customer_id', $custIds);    
        }       

        $count = $query->count();

        return $count;
    }
    public function rejectedOrders()
    {

        $custIds = $this->getCustomers();

        $query = Order::where('order_status_id', 10);

        if(!empty($custIds)){ 
            // condition applied for search by parent or team lead/agent login or search by user
            $query->whereIn('orders.customer_id', $custIds);    
        }       

        $count = $query->count();

        return $count;
    }

    public function pendingComplaints()
    {

        $Team = $this->getTeams();

        $query = Complaint::whereIn('status', [1,2,4]);// all pending complaints

        if(!empty($Team)){ 
            // condition applied for search by parent or team lead/agent login or search by user
            $query->whereIn('reported_by', $Team);    
        }
        $count = $query->count();

        return $count;
    }

    public function getTeams()
    {
        $Team = [];

        if(auth()->user()->hasRole('Team Lead') ){   // search by team
            array_push($Team, auth()->user()->id); 

            $tusers = User::where('parentid', auth()->user()->id)->pluck('id')->toArray();        
            $Team = array_merge($Team, $tusers);

        }else if(auth()->user()->hasRole('Agent')){  // search by user
            array_push($Team, auth()->user()->id); 

        }
        return $Team;
    }

    public function getCustomers($team=true)
    {   
        $custIds = [];

        if(!$team){
            $custIds = Customer::all()->pluck('id')->toArray();

        }else{
            $Team = $this->getTeams();

            if(!empty($Team)){
                $custIds = Customer::whereIn('customers.refferedby', $Team)
                            ->get()
                            ->pluck('id')->toArray();

            }
        }
        
        return $custIds;
    }
}
