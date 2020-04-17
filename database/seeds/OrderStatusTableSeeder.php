<?php

use Illuminate\Database\Seeder;
use App\OrderStatus;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $statuses = [
          'open',
          'document_accepted',
          'document_rejected',
          'marketing_approved',
          'marketing_failed',
          'lead_created',
          'authority_approved',
          'authority_rejected',
          'order_created',
          'order_rejected',
          'item_delivered',
          'activation_pending',
          'activation_complete',
          'activation_complete',
          'initial',
        ];
   
        foreach ($statuses as $status) {
          OrderStatus::create(['name' => $status]);
        }
    }
}