<?php

namespace App\Imports;
   
use App\Customer;
use App\User;
use App\Order;
use App\OrderHistory;
use App\OrderPlan;
use Carbon\Carbon;
use DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
    
use Maatwebsite\Excel\Concerns\Importable;    
class RetentionImport implements ToModel, WithHeadingRow, WithCalculatedFormulas, WithChunkReading, WithBatchInserts
{   
    use Importable;
  
    // /**
    // * @param array $row
    // *
    // * @return \Illuminate\Database\Eloquent\Model|null
    // */
    public function model(array $row)
    {
    
        if(!array_filter($row)) { return null;}  

        if(isset($row['account_no']) && $row['account_no']){            

            if(!trim($row['gsm_total'])){
                return null;
            }

            $order = DB::table('orders')
                    ->join('customers', 'customers.id', '=', 'orders.customer_id')
                    ->select('orders.*')
                    ->where('customers.account_no', '=', $row['account_no'])
                    ->first(); 

            #### Order Plans  
            $plan_insert = []; $res = '';

            if(trim($row["data_100_gb"]) != null && trim($row["data_100_gb"]) >0 ){
                $q = (int) trim($row["data_100_gb"]);
                $p = 600;

                $plan_insert = [
                                "order_id"   => $order->id,
                                "price"      => $p,
                                "plan"       => "Data 100GB",
                                "plan_id"    => 3,
                                "plan_type"  => "Old",   
                                "quantity"   => $q,
                                "total"      => ($q * $p)
                            ];
                return new OrderPlan($plan_insert);
            
            }else{
                return null;
            } 
        }   


        return null;

    } 

    public function chunkSize(): int
    {
        return 100;
    }

    public function batchSize(): int
    {
        return 100;
    }

}