<?php

namespace Database\Seeders;

use App\Models\Companies;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            [
                "user_id" => 2,
                "name" => "Smart Axiata Co, Ltd.",
                "slug" => "smart-axiata",
                "logo_path" => "logo.png",
                "website_url" => "https://www.smart.com.kh/km",
                "industry" => "Telcommunication",
                "company_size" => "Large",
                "location" => "Head Quarter Based in Monivong",
                "description" => "Smart Jivit Rous Rovery"
            ],
            [
                "user_id" => 4,
                "name" => "Cellcard Co, Ltd.",
                "slug" => "cell-card",
                "logo_path" => "cellcard.png",
                "website_url" => "https://www.cellcard.com.kh/en",
                "industry" => "Telcommunication",
                "company_size" => "Large",
                "location" => "Head Quarter Based in Monivong",
                "description" => "Cellcard Jivit Rous Rovery"
            ]
        ];

        foreach($companies as $key => $value) {
            Companies::create($value);
        }
    }
}
