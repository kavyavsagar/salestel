<?php

use Illuminate\Database\Seeder;
use App\Plan;

class PlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $planlist = [
          'Executive 10 GB',
          'Executive 100 GB',
          'Summer',
          'Hybrid 350 & 1.2',
          'Hybrid',
          'Plus',
          'Special',
          'Super 12',
          'Super 24',
          'Unlimitted',
        ];
   
        foreach ($planlist as $plan) {
          Plan::create(['plan' => $plan,'plan_type' => 'mobile']);
        }

        $planlist = [
          'Business Complete 80mbps',
          'Business Complete 175mbps',
	      'Business Complete 275mbps',
	      'Business Complete 500mbps',
	      'Business Complete 1208mbps',
          'Business Essential 80mbps',
          'Business Essential 120mbps',
          'Business Essential 175mbps',
          'Business Essential 275mbps',
          'Business Essential 500mbps',
        ];
   
        foreach ($planlist as $plan) {
          Plan::create(['plan' => $plan,'plan_type' => 'fixed']);
        }
    }
}
