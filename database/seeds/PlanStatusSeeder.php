<?php

use Illuminate\Database\Seeder;
use App\PlanStatus;

class PlanStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $planstatus = [
        				['name' => 'New',
        				'code'	=> 'New'],
        				['name' => 'MNP',
        				'code'	=> 'MNP'],
        				['name' => 'Migrated',
        				'code'	=> 'Migrated'],
        				['name' => 'Renewal',
        				'code'	=> 'Renewal'],
        				['name' => 'Upgrade',
        				'code'	=> 'Upgrade'],
        				['name' => 'Downgrade',
        				'code'	=> 'Downgrade'],
        				['name' => 'Vas',
        				'code'	=> 'Vas'],
        				['name' => 'Vas',
        				'code'	=> 'Vas'],
        				['name' => 'Rate Plan Change',
        				'code'	=> 'RPC'],
        				['name' => 'Cancel',
        				'code'	=> 'Cancel'],
        			];

        foreach ($planstatus as $plan) {
          	PlanStatus::create($plan);
        }
    }
}