<?php

namespace Database\Seeders;

use App\Models\Resumes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResumesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resumes = [
            [
                "user_id" => 3,
                "file_path" => "testing.docx",
                "file_name" => "MyResume",
                "mime_type" => "MS Word.",
                "is_default" => 1
            ]
        ];

        foreach($resumes as $key => $value) {
            Resumes::create($value);
        }
    }
}
