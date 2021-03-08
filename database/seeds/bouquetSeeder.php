<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class bouquetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // public function run()
    // {
        public function run()
		    {
		    $time = strtotime(date("Y/m/d"));

        	$one_month_plus = date("Y-m-d", strtotime("+1 year", $time));

		   	foreach (range(1,2560) as $index) {
    
		        DB::table('bouquet_trackings')->insert([
		            'user_id' => rand(1, 2600),
		            'end_at' => $one_month_plus,
		            'ads_number' => 10,
		            'available_ads' => 10,
		            'social_media' => 1,
		            'featured_ads_number' => 0,
		            'mobile_notification' => 0,
		            'available_photo_services' => 0	,
		            'created_at' => Carbon::now()	,
		            'updated_at' => Carbon::now()	,
		            // 'is_admin' => 0,
		            // 'status' => -1,
		        ]);
		    }
     }
}

