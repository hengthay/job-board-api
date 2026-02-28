<?php

namespace Database\Seeders;

use App\Models\Application;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $applications = [
            [
                "job_id" => 1,
                "user_id" => 3,
                "resume_id" => 1,
                "cover_letter" => "This is my cover letter to hiring manager",
            ]
        ];

        foreach($applications as $key => $value) {
            Application::create($value);
        }
    }
}
