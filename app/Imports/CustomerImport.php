<?php
   
namespace App\Imports;
   
use App\Dsr;
use Carbon\Carbon;
use DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
    
class CustomerImport implements ToModel, WithHeadingRow
{
    use Importable;

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        if(!array_filter($row)) { return null;}

        if(isset($row['company'])){

            //check for customer already exists
            $ifExists = Dsr::where('company', trim($row['company']))->count();
            if($ifExists >0) {
                return null;
            }
      
            return new Dsr([
                'company'        => isset($row['company'])?$row['company']: '',               
                'contact_name'   => isset($row['contactname'])?$row['contactname']:'',
                'email'          => isset($row['email'])?$row['email']: '', 
                'phone'          => isset($row['phone'])?$row['phone']: '',
                'refferedby'     => auth()->user()->id,
                'dsr_status'     => 1
            ]);
            
        }
    }

    // public function sheets(): array
    // {
    //     return [
    //         // Select by sheet index
    //         0 => new CustomerImport(),
    //     ];
    // }
    
}