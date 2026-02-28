<?php

namespace Database\Seeders;

use App\Models\CompanySocial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companySocials = [
            [
                "company_id" => 1,
                "platform" => "Website",
                "url" => "https://www.smart.com.kh/km"
            ],
            [
                "company_id" => 2,
                "platform" => "Website",
                "url" => "https://www.cellcard.com.kh"
            ]
        ];

        foreach($companySocials as $key => $value) {
            CompanySocial::create($value);
        }
    }
}
