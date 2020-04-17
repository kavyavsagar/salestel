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
            ->select('orders.id', 'customers.company_name', 'orders.plan_type', 'orders.total_amount', 'users.fullname', 'order_statuses.name AS status', 'orders.created_at' )
            ->where('orders.order_status_id','<>', 14); // initial status -DSR 

        if(isset($input['statusid']) && $input['statusid'] !=0 ){
            $query->where('orders.order_status_id','=', $input['statusid']);
        }              

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
        $orders = $query->get();

        return $orders;
    }

    public function headings(): array
    {
        return [
            '#',
            'Company',
            'Plan Type',
            'Amount (AED)',
            'Reffered by',
            'Status',
            'Created at'
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
