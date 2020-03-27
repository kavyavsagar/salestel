<?php

use Illuminate\Database\Seeder;
use App\Pricing;

class PricingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $mob_prices = [
          50,
          100,
          150,
          200,
          300,
          350,
          400,
          450,
          500,
          900,
          1000,
          1200,
          1500,

        ];
   
        foreach ($mob_prices as $price) {
          Pricing::create(['amount' => $price,'plan_type' => 'mobile']);
        }

        // fixed
        $fix_prices = [
          810,
          950,
          1000,
          1250,
          1350,
          1450,
          1550,
          1750,
          1850,
          2250,
          2850,
          2990,
          3000,
          3650,
        ];
   
        foreach ($fix_prices as $price) {
          Pricing::create(['amount' => $price,'plan_type' => 'fixed']);
        }
    }
}
