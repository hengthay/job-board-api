<?php

namespace App\Http\Controllers;

use App\Models\CandidateProfile;
use App\Models\Companies;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\JobType;
use App\Models\User;

class DashboardController extends Controller
{

  public function getStatData() {
    try {
      return $this->handleResponse([
        'users' => User::count(),
        'candidateProfiles' => CandidateProfile::count(),
        'jobs' => Job::count(),
        'companies' => Companies::count(),
        'jobTypes' => JobType::count(),
        'jobCategories' => JobCategory::count()
      ], 'All Stat Data is retrieve successfully!');

    } catch (\Throwable $e) {
      return $this->handleErrorResponse(null, $e->getMessage(), 500);
    }
  }
}