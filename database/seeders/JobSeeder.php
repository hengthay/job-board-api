<?php

namespace Database\Seeders;

use App\Models\Job;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobs = [
            [
                "company_id" => 1,
                "job_category_id" => 3,
                "job_type_id" => 1,
                "title" => "Web Developer",
                "description" => "We are looking for a candidate who able to working on presure and have a solid knowledge on Web Devloper to maintain on Company projects and website.",
                "requirements" => [
                    "React",
                    "TypeScript",
                    "Node JS",
                    "Express",
                    "Laravel",
                    "MySQL",
                    "MongoDB"
                ],
                "benefits" => [
                    "NSSF",
                    "Bonus",
                    "Seniority",
                    "Salary",
                    "Insurance",
                    "General Service",
                    "Health Check"
                ],
                "location" => "Head Office, Monivong",
                "work_mode" => "On-site",
                "salary_min" => 800,
                "salary_max" => 1200,
                "vacancies" => 3,
                "deadline" => Carbon::create(2026, 3, 31),
                "status" => "open",
                "published_at" => Carbon::create(2026, 3, 1),
                "closed_at" => Carbon::create(2026, 3, 31)
            ],
            [
                "company_id" => 2,
                "job_category_id" => 3,
                "job_type_id" => 1,
                "title" => "Flutter Developer",
                "description" => "We are looking for a candidate who able to working on presure and have a solid knowledge on Flutter to maintain on Company projects and website.",
                "requirements" => [
                    "Flutter",
                    "Dart",
                    "Node JS",
                    "Express",
                    "Laravel",
                    "MySQL",
                    "MongoDB"
                ],
                "benefits" => [
                    "NSSF",
                    "Bonus",
                    "Seniority",
                    "Salary",
                    "Insurance",
                    "General Service",
                    "Health Check"
                ],
                "location" => "Head Office, Monivong",
                "work_mode" => "On-site",
                "salary_min" => 1000,
                "salary_max" => 1500,
                "vacancies" => 1,
                "deadline" => Carbon::create(2026, 3, 31),
                "status" => "open",
                "published_at" => Carbon::create(2026, 3, 1),
                "closed_at" => Carbon::create(2026, 3, 31)
            ],
        ];

        foreach($jobs as $key => $value) {
            Job::create($value);
        }
    }
}
