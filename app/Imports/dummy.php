<?php
 public createCustomer($row){

        if(isset($row['account_no']) && $row['account_no']){   
            $cExists = Customer::where('account_no', $row['account_no'])->count();

            if(!$cExists){

                return new Customer([
                            'company_name'     => isset($row['company_name'])?$row['company_name']: '',
                            'account_no'       => isset($row['account_no'])?$row['account_no']: '',
                            'authority_name'   => isset($row['customer_name'])?$row['customer_name']:'',
                            'authority_email'  => isset($row['email_address'])?$row['email_address']: '', 
                            'authority_phone'  => isset($row['mobile_number'])?$row['mobile_number']: '',
                            'technical_name'   => '',
                            'technical_email'  => '', 
                            'technical_phone'  => '',
                            'refferedby'       => auth()->user()->id,
                            'status'           => 1
                        ]); 
            }
        }

        return false;
    }
    
    public function createOrder($row){
        if(isset($row['account_no']) && $row['account_no']){
            
            $customer = Customer::where('account_no', $row['account_no'])->first();

            if(!trim($row['gsm_total'])){
                 return null;
            }
            $order_insert = ["customer_id" => $customer->id,
                        "plan_type" => 'mobile',
                        "total_amount" => trim($row['gsm_total']),
                        "order_status_id" => 13
                    ];

            #### Order Insert
            $order =  Order::create($order_insert); 

             #### Order Status History
            $status_insert = [
                        "order_id"        => $order->id,
                        "order_status_id" => 13,
                        "comments"        => (isset($row['status']) &&  $row['status'])? $row['status']: 'Retention Order',
                        "added_by"        => auth()->user()->id
                    ];

            return new OrderHistory($status_insert); 

        }    
    }

  

    public function createOrderPlans($row){

        $plan_insert = [];
        foreach ($row as $key => $val) {
            $price = 0; $plan = ''; $total = 0;

            if(!trim($val)){
                continue;
            }

            $split = explode("_", $key);
            $len = count($split);
            $last = $split[$len-1];
  
            if($len >1 && preg_match('/^\d+$/', $last) ){
                $price = $split[$len-1];
                $total = $price * $val;

                array_pop($split);
                $pl = ($len > 2)? implode(" ", $split): $key;

                $pRow = DB::table('plans')->where([
                                ['plan', '=', $pl],
                                ['plan_type', '=', $type]
                            ])->get();

                #### Order Plans                
                if($pRow && count($pRow)>0){
                    $planRow = $pRow->first();

                    $plan_insert[] = [
                                "order_id"   => $order->id,
                                "price"      => $price,
                                "plan"       => $planRow->plan,
                                "plan_id"    => $planRow->id,
                                "plan_type"  => $type,    
                                "quantity"   => $val,
                                "total"      => $total,
                                "created_at" => \Carbon\Carbon::now(), # new \Datetime()
                                "updated_at" => \Carbon\Carbon::now()  # new \Datetime()
                            ];
                }else{ continue;}           
                
            }else{
                continue;
            }
        }

        #### Order Plans
        DB::table('order_plans')->insert($plan_insert);
    }


// if(trim($row["bmp_50"]) != null && trim($row["bmp_50"]) >0 ){
//                 $q = (int) trim($row["bmp_50"]);
//                 $p = 50;

//                 $plan_insert = [
//                                 "order_id"   => $order->id,
//                                 "price"      => $p,
//                                 "plan"       => "bmp",
//                                 "plan_id"    => 2,
//                                 "plan_type"  => 'MNP',    
//                                 "quantity"   => $q,
//                                 "total"      => ($q * $p)
//                             ];
//                 return new OrderPlan($plan_insert);
//             }

 // if(trim($row["bmp_100"]) != null && trim($row["bmp_100"]) >0 ){
            //     $q = (int) trim($row["bmp_100"]);
            //     $p = 100;

            //     $plan_insert[] = [
            //                         "order_id"   => $order->id,
            //                         "price"      => $p,
            //                         "plan"       => "bmp",
            //                         "plan_id"    => 2,
            //                         "plan_type"  => 'MNP',    
            //                         "quantity"   => $q,
            //                         "total"      => ($q * $p)
            //                     ];
            //     // return new OrderPlan($plan_insert);
            // }
            // if(trim($row["bmp_150"]) != null && trim($row["bmp_150"]) >0 ){
            //     $q = (int) trim($row["bmp_150"]);
            //     $p = 150;

            //     $plan_insert[] = [
            //                         "order_id"   => $order->id,
            //                         "price"      => $p,
            //                         "plan"       => "bmp",
            //                         "plan_id"    => 2,
            //                         "plan_type"  => 'MNP',    
            //                         "quantity"   => $q,
            //                         "total"      => ($q * $p)
            //                     ];
            //    // $res = OrderPlan::create($plan_insert);
            // }
            // if(trim($row["bmp_200"]) != null && trim($row["bmp_200"]) >0 ){
            //     $q = (int) trim($row["bmp_200"]);
            //     $p = 200;

            //     $plan_insert[] = [
            //                         "order_id"   => $order->id,
            //                         "price"      => $p,
            //                         "plan"       => "bmp",
            //                         "plan_id"    => 2,
            //                         "plan_type"  => 'MNP',    
            //                         "quantity"   => $q,
            //                         "total"      => ($q * $p)
            //                     ];
            //    // $res = OrderPlan::create($plan_insert);
            // }
            // if(trim($row["bmp_300"]) != null && trim($row["bmp_300"]) >0 ){
            //     $q = (int) trim($row["bmp_300"]);
            //     $p = 300;

            //     $plan_insert[] = [
            //                         "order_id"   => $order->id,
            //                         "price"      => $p,
            //                         "plan"       => "bmp",
            //                         "plan_id"    => 2,
            //                         "plan_type"  => 'MNP',    
            //                         "quantity"   => $q,
            //                         "total"      => ($q * $p)
            //                     ];
            //    // $res = OrderPlan::create($plan_insert);
            // }
            // if(trim($row["bmp_350"]) != null && trim($row["bmp_350"]) >0 ){
            //     $q = (int) trim($row["bmp_350"]);
            //     $p = 350;

            //     $plan_insert[] = [
            //                         "order_id"   => $order->id,
            //                         "price"      => $p,
            //                         "plan"       => "bmp",
            //                         "plan_id"    => 2,
            //                         "plan_type"  => 'MNP',    
            //                         "quantity"   => $q,
            //                         "total"      => ($q * $p)
            //                     ];
            //     //$res = OrderPlan::create($plan_insert);
            // }
            // if(trim($row["bmp_450"]) != null && trim($row["bmp_450"]) >0 ){
            //     $q = (int) trim($row["bmp_450"]);
            //     $p = 450;

            //     $plan_insert[] = [
            //                         "order_id"   => $order->id,
            //                         "price"      => $p,
            //                         "plan"       => "bmp",
            //                         "plan_id"    => 2,
            //                         "plan_type"  => 'MNP',    
            //                         "quantity"   => $q,
            //                         "total"      => ($q * $p)
            //                     ];
            //     //$res = OrderPlan::create($plan_insert);
            // }
            // if(trim($row["bmp_500"]) != null && trim($row["bmp_500"]) >0 ){
            //     $q = (int) trim($row["bmp_500"]);
            //     $p = 500;

            //     $plan_insert[] = [
            //                         "order_id"   => $order->id,
            //                         "price"      => $p,
            //                         "plan"       => "bmp",
            //                         "plan_id"    => 2,
            //                         "plan_type"  => 'MNP',    
            //                         "quantity"   => $q,
            //                         "total"      => ($q * $p)
            //                     ];
            //     //$res = OrderPlan::create($plan_insert);
            // }
            // if(trim($row["bmp_900"]) != null && trim($row["bmp_900"]) >0 ){
            //     $q = (int) trim($row["bmp_900"]);
            //     $p = 900;

            //     $plan_insert[] = [
            //                         "order_id"   => $order->id,
            //                         "price"      => $p,
            //                         "plan"       => "bmp",
            //                         "plan_id"    => 2,
            //                         "plan_type"  => 'MNP',    
            //                         "quantity"   => $q,
            //                         "total"      => ($q * $p)
            //                     ];
            //     //$res = OrderPlan::create($plan_insert);
            // }
            // if(trim($row["bmp_1000"]) != null && trim($row["bmp_1000"]) >0 ){
            //     $q = (int) trim($row["bmp_1000"]);
            //     $p = 1000;

            //     $plan_insert[] = [
            //                         "order_id"   => $order->id,
            //                         "price"      => $p,
            //                         "plan"       => "bmp",
            //                         "plan_id"    => 2,
            //                         "plan_type"  => 'MNP',    
            //                         "quantity"   => $q,
            //                         "total"      => ($q * $p)
            //                     ];
            //     //$res = OrderPlan::create($plan_insert);
            // }
            // if(trim($row["handset_25"]) != null && trim($row["handset_25"]) >0 ){
            //     $q = (int) trim($row["handset_25"]);
            //     $p = 25;

            //     $plan_insert[] = [
            //                         "order_id"   => $order->id,
            //                         "price"      => $p,
            //                         "plan"       => "handset",
            //                         "plan_id"    => 1,
            //                         "plan_type"  => 'MNP',    
            //                         "quantity"   => $q,
            //                         "total"      => ($q * $p)
            //                     ];
            //     //$res = OrderPlan::create($plan_insert);
            // }
            // if(trim($row["data_50gb_250"]) != null && trim($row["data_50gb_250"]) >0 ){
            //     $q = (int) trim($row["data_50gb_250"]);
            //     $p = 250;

            //     $plan_insert[] = [
            //                         "order_id"   => $order->id,
            //                         "price"      => $p,
            //                         "plan"       => "data 50gb",
            //                         "plan_id"    => 3,
            //                         "plan_type"  => 'MNP',    
            //                         "quantity"   => $q,
            //                         "total"      => ($q * $p)
            //                     ];
            //     //$res = OrderPlan::create($plan_insert);
            // }
            // if(trim($row["data_100gb_600"]) != null && trim($row["data_100gb_600"]) >0 ){
            //     $q = (int) trim($row["data_100gb_600"]);
            //     $p = 600;

            //     $plan_insert[] = [
            //                         "order_id"   => $order->id,
            //                         "price"      => $p,
            //                         "plan"       => "data 100gb",
            //                         "plan_id"    => 4,
            //                         "plan_type"  => 'MNP',    
            //                         "quantity"   => $q,
            //                         "total"      => ($q * $p)
            //                     ];
            //     //$res = OrderPlan::create($plan_insert);
            // }
?>