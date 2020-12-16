<?php

namespace App\Exports;
use App\Dsr;
use App\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;

class DsrExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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
        $arUser = User::all()->toArray();        

        $Team = [];       

        $tusers = []; $users =[];// $unique_parent =[];
        foreach ($arUser as $key => $us) {
      
            if(auth()->user()->hasAnyRole(['Coordinator', 'Admin'])) { 
                // admin, coordinator
                $users[$us['id']] =  $us['fullname'];
            }

            // get unique parent ids
            // if($us['parentid'] !=0 && !in_array($us['parentid'], $unique_parent)){
            //     $unique_parent[$us['parentid']] = $us['parentid'];
            // }

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
            ->select('dsr.company','dsr.contact_name', 'dsr.phone','dsr.location','dsr.remarks','u.fullname', 'st.name as status', 'dsr.updated_at'); // initial
             
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
        $dsr = $query->get();

        if(empty($dsr)){ return null;}

        return $dsr;
    }

    public function headings(): array
    {
        return [            
            'Company',
            'Person',    
            'Phone',     
            'Location',
            'Remarks',
            'Reffered by',
            'Status',
            'Last Date'            
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
