<?php

namespace Database\Seeders;

use App\Models\SaveJob;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaveJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $saveJobs = [
            [
                "user_id" => 3,
                "job_id" => 1,
            ]
        ];

        foreach($saveJobs as $key => $value) {
            SaveJob::create($value);
        }
    }
}
