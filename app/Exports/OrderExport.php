<?php

namespace App\Exports;
use App\Order;
use App\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;

class OrderExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{


	protected $searchq = [];

	function __construct($data) {
	    $this->searchq = $data;
	}
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

    	$input = $this->searchq;

        // Users
        $Team = []; $tusers = []; 

        if(isset($input['parentid']) && $input['parentid'] !=0 ){   // search by team
            array_push($Team, $input['parentid']); 
            $tusers = User::where('parentid', $input['parentid'])->pluck('id')->toArray();        
            $Team = array_merge($Team, $tusers);

        }else if(isset($input['userid']) && $input['userid'] !=0 ){  // search by user
            array_push($Team, $input['userid']); 

        }else if(auth()->user()->hasRole('Team Lead')){           
            array_push($Team, auth()->user()->id);  // for agent and team lead  
            $tusers = User::where('parentid', auth()->user()->id)->pluck('id')->toArray(); 
                     
            $Team = array_merge($Team, $tusers);            
        }

        $custIds = [];

        if(!empty($Team)){
            $custIds = DB::table('customers')->whereIn('customers.refferedby', $Team)
                    ->get()
                    ->pluck('id')->toArray();
        }
        $from = new Carbon('2020-06-28');
        $query = DB::table('orders')
            ->join('order_statuses', 'order_statuses.id', '=', 'orders.order_status_id')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('users', 'users.id', '=', 'customers.refferedby')                        
            ->whereDate('orders.created_at', '>', $from);      
            

        $date_fld = 'orders.created_at';
        if(isset($input['statusid']) && $input['statusid'] !=0 ){
            $query->where('orders.order_status_id','=', $input['statusid']);
            if($input['statusid'] == 13 || $input['statusid'] == 23){//completed / Partial
                $date_fld = 'orders.updated_at';
            }
        }else{
            $query->where('orders.order_status_id','<>', 13);
        }              

        if(!empty($custIds)){ 
            // condition applied for search by parent or team lead/agent login or search by user
            $query->whereIn('orders.customer_id', $custIds);    
        }else{
            if( (isset($input['parentid']) && $input['parentid'] >0) || 
                (isset($input['userid']) && $input['userid'] >0) ) { 
                $query->where('orders.customer_id', 0); 
            }
        }        
        
        if(isset($input['start_date']) && $input['start_date'] != ""
            && isset($input['end_date']) && $input['end_date'] != ""){  // Search by dates
            
            $from =  new Carbon($input['start_date']);           
            $to =   new Carbon($input['end_date']);
            
           $query->whereBetween($date_fld, array($from.'.000000', $to->endOfDay().'.000000' ));          
        }

        $planflag = false;
        if(isset($input['planid']) && $input['planid'] != 0){
            $planids = explode("_",$input['planid']);
            $planflag = true;

            $query->join("order_plans", function ($join) use($planids) {
                
                    $join->on('orders.id', '=', 'order_plans.order_id')                        
                         ->where('order_plans.plan_id', '=', $planids[0])
                         ->where('order_plans.price', '=', $planids[1])
                         ->select('order_plans.quantity', 'order_plans.plan');
                });
            
            $query->select('orders.id', 'customers.company_name','customers.account_no', 'users.fullname', 'order_statuses.name AS status', 'orders.created_at', 'order_plans.plan', 'order_plans.price' ,'order_plans.quantity');

        }else{
            $planflag = false;
            $query->select('orders.id', 'customers.company_name','customers.account_no', 'users.fullname', 'order_statuses.name AS status', 'orders.created_at','orders.plan_type', 'orders.total_amount', 'orders.partial_amount');
        }
       

        $query->orderBy('orders.id', 'DESC');
        $orders = $query->get(); 

        if(empty($orders)){ return null;}

        return $orders;
    }

    public function headings(): array
    {
        return [
            '#',
            'Company',
            'Account',            
            'Reffered by',
            'Status',
            'Created at',           
            'Plan Type',
            'Amount (AED)',
            'Quantity'
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }
}
