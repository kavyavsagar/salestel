<?php
   
namespace App\Imports;
   
use App\Customer;
use App\User;
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

        //check for customer already exists
        //$ifExists = Customer::where('authority_email', $row['email'])->count();
        
        //if(!$ifExists){
            
            return new Customer([
                'company_name'     => isset($row['company'])?$row['company']: '',
                'account_no'       => '',
                'authority_name'   => isset($row['contactname'])?$row['contactname']:'',
                'authority_email'  => isset($row['email'])?$row['email']: '', 
                'authority_phone'  => isset($row['phone'])?$row['phone']: '',
                'technical_name'   => '',
                'technical_email'  => '', 
                'technical_phone'  => '',
                'refferedby'       => auth()->user()->id
            ]);
        //}
    }

    // public function sheets(): array
    // {
    //     return [
    //         // Select by sheet index
    //         0 => new CustomerImport(),
    //     ];
    // }
    
}