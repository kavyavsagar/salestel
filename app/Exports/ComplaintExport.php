<?php

namespace App\Exports;
use App\Complaint;
use App\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;

class ComplaintExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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

    //	$input = $this->searchq;
      

        // Users
        $query = DB::table('complaints')
            ->join('users AS u1', 'u1.id', '=', 'complaints.reported_by')
            ->join('complaint_statuses AS cs', 'cs.id', '=', 'complaints.status')
            ->select('complaints.customer_acc_no','complaints.comp_no', 'complaints.description','u1.fullname', 'cs.name as status_name', 'complaints.created_at' )
            ->where('complaints.status','<>', 3);
       
        $complaints = $query->get();
       
        if(empty($complaints)){ return null;}

        return $complaints;
    }

    public function headings(): array
    {
        return [           
            'Company',
            'RefNo',   
            'Description',         
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
