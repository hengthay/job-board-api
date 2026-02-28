<?php

namespace Database\Seeders;

use App\Models\JobCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobCategories = [
            ["name" => "Information Technology (IT)"],
            ["name" => "Software Development"],
            ["name" => "Web & Mobile Development"],
            ["name" => "Cybersecurity"],
            ["name" => "Data Science & AI"],
            ["name" => "Networking & Infrastructure"],
            ["name" => "Accounting & Finance"],
            ["name" => "Banking & Investment"],
            ["name" => "Auditing & Taxation"],
            ["name" => "Marketing & Digital Marketing"],
            ["name" => "Sales & Business Development"],
            ["name" => "Customer Service"],
            ["name" => "Human Resources (HR)"],
            ["name" => "Administration & Office Support"],
            ["name" => "Engineering"],
            ["name" => "Civil Engineering"],
            ["name" => "Mechanical Engineering"],
            ["name" => "Electrical Engineering"],
            ["name" => "Healthcare & Medical"],
            ["name" => "Pharmacy"],
            ["name" => "Nursing"],
            ["name" => "Education & Training"],
            ["name" => "Research & Development"],
            ["name" => "Construction"],
            ["name" => "Architecture & Interior Design"],
            ["name" => "Logistics & Supply Chain"],
            ["name" => "Transportation"],
            ["name" => "Manufacturing & Production"],
            ["name" => "Quality Control"],
            ["name" => "Hospitality & Tourism"],
            ["name" => "Food & Beverage"],
            ["name" => "Retail & Merchandising"],
            ["name" => "E-commerce"],
            ["name" => "Media & Communication"],
            ["name" => "Graphic Design & Creative"],
            ["name" => "Legal & Compliance"],
            ["name" => "Security Services"],
            ["name" => "Agriculture"],
            ["name" => "Real Estate"],
            ["name" => "Government & Public Sector"],
            ["name" => "Other"]
        ];

        foreach($jobCategories as $key => $value) {
            JobCategory::create($value);
        }
    }
}
