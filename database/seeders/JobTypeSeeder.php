<?php

namespace Database\Seeders;

use App\Models\JobType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobTypes = [
            [
                "name" => "Full-Time"
            ],
            [
                "name" => "Part-Time"
            ],
            [
                "name" => "Contract"
            ],
            [
                "name" => "Temporary"
            ],
            [
                "name" => "Internship"
            ],
            [
                "name" => "Freelance"
            ],
            [
                "name" => "Remote"
            ],
            [
                "name" => "Hybrid"
            ],
            [
                "name" => "On-site"
            ],
            [
                "name" => "Volunteer"
            ],
        ];

        foreach($jobTypes as $key => $value) {
            JobType::create($value);
        }
    }
}
