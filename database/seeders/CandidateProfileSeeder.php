<?php

namespace Database\Seeders;

use App\Models\CandidateProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidateProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profiles = [
            [
                "user_id" => 3,
                "title" => "Full-Stack Developer",
                "profile_image" => "profile.png",
                "summary" => "Full-Stack Developer right here",
                "location" => "Sangkat Phsar Derm Tkov, Khan Chamkar Morn, Phnom Penh",
                "experience_years" => 3,
                "portfolio_url" => "https://hengthay-portfolio-website.vercel.app",
                "linkedin_url" => "https://www.linkedin.com/in/laov-kimhengthay-047a232b1/",
                "github_url" => "https://github.com/hengthay"
            ]
        ];

        foreach($profiles as $key => $value) {
            CandidateProfile::create($value);
        }
    }
}
