<?php

namespace Database\Seeders;

use App\Models\Camera;
use App\Models\Customer;
use App\Models\Recorder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $customers= Customer::factory()->count(3)->create();
            foreach ($customers as $customer) {
                $recorders=Recorder::factory()->count(5)->create(['customer_id'=>$customer->id]);
                    foreach ($recorders as $recorder) {
                        Camera::factory()->count(7)->create(['recorder_id'=>$recorder->id]);
                    }
                }

    }
}
