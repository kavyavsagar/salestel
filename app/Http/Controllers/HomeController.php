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
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $this_start_month;
    protected $this_end_month;
    protected $start_month;
    protected $end_month;
    protected $currentMonth;

    public function __construct()
    {
        $this->middleware('auth');

        $this->start_month =  new Carbon('2020-06-28 00:00:00');//Carbon::now()->startOfMonth();
        $this->end_month =  Carbon::now()->subMonth()->endOfMonth();
        $this->currentMonth = date('m');

        $this->this_start_month =Carbon::now()->startOfMonth();
        $this->this_end_month =Carbon::now()->endOfMonth();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $neworders = $this->newOrders();      
 
        $comporders = $this->completedOrders();

        $flag = false; // for admin & coordinator
        if(auth()->user()->hasAnyRole('Agent', 'Team Lead')){           
           $flag = true;
        }

        $customers = count($this->getCustomers($flag));

        $complaints = $this->pendingComplaints();

        $target = $this->individualGoal();

        return view('home', compact('neworders', 'comporders', 'customers', 'complaints', 'target') );

    }
    public function newOrders(){

        $custIds = $this->getCustomers();

        $query = Order::whereBetween('created_at',[$this->start_month,$this->end_month]);

        if(auth()->user()->hasAnyRole('Agent', 'Team Lead')){           
            
            // condition applied for search by parent or team lead/agent login or search by user
            $query->whereIn('orders.customer_id', $custIds);    
          
        }else{

            if(!empty($custIds)){ 
                // condition applied for search by parent or team lead/agent login or search by user
                $query->whereIn('orders.customer_id', $custIds);    
            }
        }       

        $count = $query->count();

        ## This Month
        $query1 = Order::whereBetween('created_at',[$this->this_start_month,$this->this_end_month]);

        if(auth()->user()->hasAnyRole('Agent', 'Team Lead')){           
            
            // condition applied for search by parent or team lead/agent login or search by user
            $query1->whereIn('orders.customer_id', $custIds);    
          
        }else{

            if(!empty($custIds)){ 
                // condition applied for search by parent or team lead/agent login or search by user
                $query1->whereIn('orders.customer_id', $custIds);    
            }
        }       

        $count1 = $query1->count();

        return ["new_last" => $count, "new_this" => $count1];
    }
    public function completedOrders(){

        $custIds = $this->getCustomers();
       // $from = new Carbon('2020-06-28');

        ###################### PENDING ORDERS #######################
        
        $query = Order::whereNotIn('order_status_id',[3, 5, 8, 10,13,16,18,20,22])->whereBetween('created_at',[$this->start_month,$this->end_month]);

        if(auth()->user()->hasAnyRole('Agent', 'Team Lead')){           
            
            // condition applied for search by parent or team lead/agent login or search by user
            $query->whereIn('orders.customer_id', $custIds);    
          
        }else{

            if(!empty($custIds)){ 
                // condition applied for search by parent or team lead/agent login or search by user
                $query->whereIn('orders.customer_id', $custIds);    
            }
        }        

        $total_count = $query->count();
        $total_revenue = $query->sum('total_amount');

        ## Current Month ##

        $query1 = Order::whereNotIn('order_status_id',[3, 5, 8, 10,13,16,18,20,22,23])->whereBetween('created_at',[$this->this_start_month,$this->this_end_month]);

        if(auth()->user()->hasAnyRole('Agent', 'Team Lead')){           
            
            // condition applied for search by parent or team lead/agent login or search by user
            $query1->whereIn('orders.customer_id', $custIds);    
          
        }else{

            if(!empty($custIds)){ 
                // condition applied for search by parent or team lead/agent login or search by user
                $query1->whereIn('orders.customer_id', $custIds);    
            }
        }        

        $total_count_now = $query1->count();
        $total_revenue_now = $query1->sum('total_amount') - $query1->sum('partial_amount');

        ################# REJECTED ORDERS ############################

        $qry = Order::whereIn('order_status_id',[3, 5, 8, 10,16,18,20,22])->whereBetween('created_at',[$this->start_month,$this->end_month]);

        //->whereDate('orders.created_at', '>', $from);

        if(auth()->user()->hasAnyRole('Agent', 'Team Lead')){           
            
            // condition applied for search by parent or team lead/agent login or search by user
            $qry->whereIn('orders.customer_id', $custIds);    
          
        }else{

            if(!empty($custIds)){ 
                // condition applied for search by parent or team lead/agent login or search by user
                $qry->whereIn('orders.customer_id', $custIds);    
            }
        }        

        $rejected_count = $qry->count();
        $rejected_revenue = $qry->sum('total_amount');

        ## Current Month ##
        $qry1 = Order::whereIn('order_status_id',[3, 5, 8, 10,16,18,20,22])->whereBetween('created_at',[$this->this_start_month,$this->this_end_month]);

        //->whereDate('orders.created_at', '>', $from);

        if(auth()->user()->hasAnyRole('Agent', 'Team Lead')){           
            
            // condition applied for search by parent or team lead/agent login or search by user
            $qry1->whereIn('orders.customer_id', $custIds);    
          
        }else{

            if(!empty($custIds)){ 
                // condition applied for search by parent or team lead/agent login or search by user
                $qry1->whereIn('orders.customer_id', $custIds);    
            }
        }        

        $rejected_count_now = $qry1->count();
        $rejected_revenue_now = $qry1->sum('total_amount');

        ###################### COMPLETED ORDERS #######################
        
        $sql = Order::where('order_status_id','=', 13)->whereBetween('updated_at',[$this->start_month,$this->end_month]);
        //->whereDate('orders.created_at', '>', $from);

        if(auth()->user()->hasAnyRole('Agent', 'Team Lead')){           
            
            // condition applied for search by parent or team lead/agent login or search by user
            $sql->whereIn('orders.customer_id', $custIds);    
          
        }else{

            if(!empty($custIds)){ 
                // condition applied for search by parent or team lead/agent login or search by user
                $sql->whereIn('orders.customer_id', $custIds);    
            }
        }    
        $completed_count = $sql->count();        
        $completed_revenue = $sql->sum('total_amount');

        ## Current Month ##
        $sql1 = Order::where('order_status_id','=', 13)->whereBetween('orders.activation_date',[$this->this_start_month,$this->this_end_month]);
        //->whereDate('orders.created_at', '>', $from);

        if(auth()->user()->hasAnyRole('Agent', 'Team Lead')){                      
            // condition applied for search by parent or team lead/agent login or search by user
            $sql1->whereIn('orders.customer_id', $custIds);    
          
        }else{

            if(!empty($custIds)){ 
                // condition applied for search by parent or team lead/agent login or search by user
                $sql1->whereIn('orders.customer_id', $custIds);    
            }
        }    
        $completed_count_now = $sql1->count();    
        $completed_revenue_now = $sql1->sum('total_amount');

        // PARTIAL ORDERS
        $sql2 = Order::where('order_status_id','=', 23)->whereBetween('orders.activation_date',[$this->this_start_month,$this->this_end_month]);
        if(auth()->user()->hasAnyRole('Agent', 'Team Lead')){                      
            // condition applied for search by parent or team lead/agent login or search by user
            $sql2->whereIn('orders.customer_id', $custIds);    
          
        }else{
            if(!empty($custIds)){ 
                // condition applied for search by parent or team lead/agent login or search by user
                $sql2->whereIn('orders.customer_id', $custIds);    
            }
        }

        $partial_count_now = $sql2->count();    
        $partial_revenue_now = $sql2->sum('partial_amount');

        $completed_count_now += $partial_count_now;  
        $completed_revenue_now += $partial_revenue_now;

        $res = ["totalCnt" => [$total_count, $total_count_now], 
                "totalAmt" => [$total_revenue, $total_revenue_now], 
                "completedCnt" => [$completed_count, $completed_count_now],
                "completedAmt" => [$completed_revenue, $completed_revenue_now],
                "rejectedCnt"  => [$rejected_count, $rejected_count_now],
                "rejectedAmt" => [$rejected_revenue, $rejected_revenue_now],
                ];

        return $res;
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

    public function getUsers(){

        if(auth()->user()->hasRole('Team Lead') ){ 
            $parent = auth()->user()->id;
            $users = User::where('parentid', $parent)->where('status', 1)
                        ->pluck('fullname', 'id')->toArray();  

        }else if(auth()->user()->hasRole('Coordinator') && auth()->user()->id == 20){ //retention manager

            $parent = auth()->user()->id;

            $users = User::where('parentid', $parent)->where('status', 1)
                        ->pluck('fullname', 'id')->toArray(); 

            //array_push($users, $parent);

        }else if(auth()->user()->hasAnyRole('Admin', 'Coordinator')){

            $users = User::where('parentid', '<>', 0)->where('status', 1)
                        ->pluck('fullname', 'id')->toArray(); 
        }

        return $users;       

    }

    public function usersTotalAmount(){

        $agents = $this->getUsers();

        $graphData = [];

        foreach ($agents as $id => $name) {

            ######### Pending Orders ##########
            $queryPend = DB::table('orders as od')
                        ->join('customers as c', 'c.id', '=', 'od.customer_id')
                        ->join('users as u', 'u.id', '=', 'c.refferedby')
                        ->whereNotIn('od.order_status_id',[3, 5, 8, 10,13,16,18,20,22])
                        ->where('u.id','=', $id)
                        ->whereBetween('od.created_at',[$this->start_month,$this->this_end_month])
                        ->select('od.total_amount', 'od.id')
                        ->get();

            ######### COMPLETED Orders ##########
            $queryComp = DB::table('orders as od')
                        ->join('customers as c', 'c.id', '=', 'od.customer_id')
                        ->join('users as u', 'u.id', '=', 'c.refferedby')
                        ->where('order_status_id','=', 13)
                        ->where('u.id','=', $id)
                        ->whereBetween('od.updated_at',[$this->this_start_month,$this->this_end_month])
                        ->select('od.total_amount', 'od.id')
                        ->get();

            $graphData[$id] = ['agent'     => $name,
                                'pending'   => $queryPend->sum('total_amount'),
                                'completed' => $queryComp->sum('total_amount')
                            ];

        }

        $teamGraph = $this->teamTotalAmount();

        return response()->json(['success'=>'Fetch customer successfully', 
                                'agentdata' => json_encode($graphData),
                                'teamdata'  => json_encode($teamGraph)
                                ]
                            );

    }

    public function teamTotalAmount(){
        
        $teams = User::where('parentid', 0)->where('status', 1)
                        ->where('id','<>', 1)
                        ->pluck('fullname', 'id')->toArray();  
        

        $graphData = [];

        foreach ($teams as $id => $name) {
            // Get team members
            $teamusers = User::where('parentid', $id)->pluck('id')->toArray(); 
            array_push($teamusers, $id); 

            ######### Pending Orders ##########
            $queryPend = DB::table('orders as od')
                        ->join('customers as c', 'c.id', '=', 'od.customer_id')
                        ->join('users as u', 'u.id', '=', 'c.refferedby')
                        ->whereNotIn('od.order_status_id',[3, 5, 8, 10,13,16,18,20,22])
                        ->whereIn('u.id', $teamusers)
                        ->whereBetween('od.created_at',[$this->start_month,$this->this_end_month])
                        ->select('od.total_amount', 'od.id')
                        ->get();

            ######### COMPLETED Orders ##########
            $queryComp = DB::table('orders as od')
                        ->join('customers as c', 'c.id', '=', 'od.customer_id')
                        ->join('users as u', 'u.id', '=', 'c.refferedby')
                        ->where('order_status_id','=', 13)
                        ->whereIn('u.id', $teamusers)
                        ->whereBetween('od.updated_at',[$this->this_start_month,$this->this_end_month])
                      //  ->orWhereMonth('activation_date', date('m'))
                        ->select('od.total_amount', 'od.id')
                        ->get();
           
            $graphData[$id] = ['team'     => $name,
                                'pending'   => $queryPend->sum('total_amount'),
                                'completed' => $queryComp->sum('total_amount')
                            ];

        }

        return $graphData;

    }

    public function individualGoal(){
        
        $user = User::where('id', auth()->user()->id)->pluck('goal')->toArray(); 

        $userids = [];
                
        if(auth()->user()->hasAnyRole('Team Lead', 'Coordinator' ) ){ 
            //team lead
            array_push($userids, auth()->user()->id);
            $agents = User::where('parentid', auth()->user()->id)->where('status', 1)
                        ->pluck('id')->toArray();  

            $userids = array_merge($userids, $agents);

        }else if(auth()->user()->hasRole('Admin')){

            $users = User::where('id', '<>', 1)->where('status', 1)
                        ->pluck('fullname', 'id')->toArray();  
        }else{
            // agent 
            array_push($userids, auth()->user()->id);
        }


        ######### Pending Orders ##########
        $queryPend = DB::table('orders as od')
                    ->join('customers as c', 'c.id', '=', 'od.customer_id')
                    ->join('users as u', 'u.id', '=', 'c.refferedby')
                    ->whereNotIn('od.order_status_id',[3, 5, 8, 10,13,16,18,20,22])
                    ->whereIn('u.id',$userids)
                    ->whereBetween('od.created_at',[$this->start_month,$this->this_end_month])
                    ->select('od.total_amount', 'od.id')
                    ->get();

        $pending_amt = $queryPend->sum('total_amount');
        $pending_per = ($pending_amt/$user[0])  * 100;

        ######### COMPLETED Orders ##########
        $queryComp = DB::table('orders as od')
                    ->join('customers as c', 'c.id', '=', 'od.customer_id')
                    ->join('users as u', 'u.id', '=', 'c.refferedby')
                    ->where('od.order_status_id','=', 13)
                    ->whereIn('u.id',$userids)
                    ->whereBetween('od.updated_at',[$this->this_start_month,$this->this_end_month])
                    ->select('od.total_amount', 'od.id')
                    ->get();

        $completed_amt = $queryComp->sum('total_amount');
        $completed_per = ($completed_amt/$user[0])  * 100;

        $goal = ['goal'         => $user[0],
                'pending'       => $pending_amt,
                'pending_per'   => $pending_per,
                'completed'     => $completed_amt,
                'completed_per' => $completed_per
                ];

        return $goal;
    }
}