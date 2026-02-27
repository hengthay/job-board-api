<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index() {
        try {
            $jobs = Job::with([
                        'company:id,user_id,name',
                        'jobCategory:id,name',
                        'jobType:id,name',
                    ])->orderBy('id', 'asc')->get();

            // $jobs = Job::orderBy('id', 'asc')->get();

            if($jobs->isEmpty()) {
                return $this->handleErrorResponse(null, 'All job is currently empty!');
            }

            return $this->handleResponse($jobs, 'All Job is successfully received!');
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }
    public function show($id) {
        try {
            $job = Job::with([
                        'company:id,user_id,name',
                        'jobCategory:id,name',
                        'jobType:id,name',
                    ])->find($id);

            if (!$job) {
                return $this->handleErrorResponse(null, "Job with ID:{$id} is not found!");
            }

            return $this->handleResponse($job, "Job with ID:{$id} is successfully received!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }
    public function create(JobRequest $request) {
        try {
            $job = Job::create([
                "company_id" => $request->company_id,
                "job_category_id" => $request->job_category_id,
                "job_type_id" => $request->job_type_id,
                "title" => $request->title,
                "description" => $request->description,
                "requirements" => $request->requirements,
                "benefits" => $request->benefits,
                "location" => $request->location,
                "work_mode" => $request->work_mode,
                "salary_min" => $request->salary_min,
                "salary_max" => $request->salary_max,
                "vacancies" => $request->vacancies,
                "deadline" => $request->deadline,
                "status" => $request->status,
                "published_at" => $request->published_at,
                "closed_at" => $request->closed_at
            ]);

            if (!$job) {
                return $this->handleErrorResponse(null, "Failed to created Job!", 404);
            }

            return $this->handleResponse($job, "Job is successfully created!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }
    public function update(JobRequest $request, $id) {
        try {
            // Get current user
            $user = Auth::user();
            $role = strtolower(trim((string) $user->role));
            $query = Job::where('id', $id);

            // Only employer can access it
            if ($role !== 'employer') {
                $query->whereHas('company', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            }
            // Find job to update by ownership
            $job = $query->first();

            if (!$job) {
                return $this->handleErrorResponse(null, "Job with ID:{$id} is not found to update!", 404);
            }

            $job->update([
                "job_category_id" => $request->job_category_id,
                "job_type_id" => $request->job_type_id,
                "title" => $request->title,
                "description" => $request->description,
                "requirements" => $request->requirements,
                "benefits" => $request->benefits,
                "location" => $request->location,
                "work_mode" => $request->work_mode,
                "salary_min" => $request->salary_min,
                "salary_max" => $request->salary_max,
                "vacancies" => $request->vacancies,
                "deadline" => $request->deadline,
                "status" => $request->status,
                "published_at" => $request->published_at,
                "closed_at" => $request->closed_at
            ]);

            return $this->handleResponse($job, "Job is successfully updated!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function adminUpdate(JobRequest $request, $id) {
        try {
            // Get current user
            $user = Auth::user();
            $role = strtolower(trim((string) $user->role));
            $query = Job::where('id', $id);

            // Only admin can access it
            if ($role !== 'admin') {
                $query->whereHas('company', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            }
            // Find job to update by ownership
            $job = $query->first();

            if (!$job) {
                return $this->handleErrorResponse(null, "Job with ID:{$id} is not found to update!", 404);
            }

            $job->update([
                "company_id" => $request->company_id,
                "job_category_id" => $request->job_category_id,
                "job_type_id" => $request->job_type_id,
                "title" => $request->title,
                "description" => $request->description,
                "requirements" => $request->requirements,
                "benefits" => $request->benefits,
                "location" => $request->location,
                "work_mode" => $request->work_mode,
                "salary_min" => $request->salary_min,
                "salary_max" => $request->salary_max,
                "vacancies" => $request->vacancies,
                "deadline" => $request->deadline,
                "status" => $request->status,
                "published_at" => $request->published_at,
                "closed_at" => $request->closed_at
            ]);

            return $this->handleResponse($job, "Job is successfully updated!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function delete($id) {
        try {
            // Get current user
            $user = Auth::user();
            $role = strtolower(trim((string) $user->role));
            // Find job to delete by ownership
            $query = Job::where('id', $id);
            // Onlu employer can access
            if ($role !== 'employer') {
                $query->whereHas('company', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            }
            // Find job to update by ownership
            $job = $query->first();

            if (!$job) {
                return $this->handleErrorResponse(null, "Job with ID:{$id} is not found to delete!", 404);
            }

            $job->delete();

            return $this->handleResponse(null, "Job is successfully deleted!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }
    public function adminDelete($id) {
        try {
            $job = Job::find($id);

            if (!$job) {
                return $this->handleErrorResponse(null, "Job with ID:{$id} is not found to delete!", 404);
            }

            $job->delete();

            return $this->handleResponse(null, "Job is successfully deleted by Admin!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }
}
