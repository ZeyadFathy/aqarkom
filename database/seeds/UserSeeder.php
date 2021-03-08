<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
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
		   	foreach (range(1,2560) as $index) {
    
		        DB::table('users')->insert([
		            'name' => Str::random(10),
		            'email' => Str::random(10).'@gmail.com',
		            'mobile' => rand(0100000000, 9999999999),
		            'mobile_code' => rand(10000, 99999),
		            'password' => Hash::make('password'),
		            // 'is_admin' => 0,
		            // 'status' => -1,
		        ]);
		    }
     }
}
