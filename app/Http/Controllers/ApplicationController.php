<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationRequest;
use App\Models\Application;
use App\Models\Job;
use App\Models\Resumes;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function index() {
        try {
            // Get current user
            $user = Auth::user();
            // Fetch by relationship table
            $query = Application::with([
                'job:id,company_id,title,status',
                'resume:id,user_id,file_name',
                'user:id,name,email'
            ])->orderBy('id', 'desc');
            // If user role equal to employer
            if($user->role === 'employer') {
                $query->whereHas('job.company', function($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            }elseif ($user->role !== 'admin') {
                $query->where('user_id', $user->id);
            }

            $applications = $query->get();

            if ($applications->isEmpty()) {
                return $this->handleErrorResponse(null, 'No applications found', 404);
            }

            return $this->handleResponse($applications, 'Applications retrieved successfully');
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function show($id) {
        try {
            // Get current user
            $user = Auth::user();
            // Fetch by relationship table
            $query = Application::with([
                'job:id,company_id,title,status',
                'resume:id,user_id,file_name',
                'user:id,name,email'
            ])->where('id', $id);
            // If user role equal to employer
            if($user->role === 'employer') {
                $query->whereHas('job.company', function($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            }elseif ($user->role !== 'admin') {
                $query->where('user_id', $user->id);
            }

            $applications = $query->first();

            if (!$applications) {
                return $this->handleErrorResponse(null, 'No applications found', 404);
            }

            return $this->handleResponse($applications, "Applications with ID:{$id} retrieved successfully");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function create(ApplicationRequest $request) {
        try {
            $user = Auth::user();

            if($user->role !== "user") {
                return $this->handleErrorResponse(null, "Only candidate can apply!", 404);
            }

            $data = $request->validated();

            $job = Job::find($data['job_id']);

            if(!$job) {
                return $this->handleErrorResponse(null, 'Job not found', 404);
            }

            if (strtolower(trim((string)$job->status)) !== 'open') {
                return $this->handleErrorResponse(null, 'Job is not open for application', 400);
            }

            $resume = Resumes::where('id', $data['resume_id'])
                                ->where('user_id', $user->id)
                                ->first();
             if (!$resume) {
                return $this->handleErrorResponse(null, 'Resume not found or not yours', 403);
            }

            $exists = Application::where('job_id', $data['job_id'])
                                    ->where('user_id', $user->id)
                                    ->exists();

            if ($exists) {
                return $this->handleErrorResponse(null, 'You already applied for this job', 409);
            }

            $application = Application::create([
                'job_id' => $data['job_id'],
                'user_id' => $user->id,
                'resume_id' => $data['resume_id'],
                'cover_letter' => $data['cover_letter'] ?? null,
                'status' => 'pending',
                'applied_at' => now()->toDateString(),
            ]);

            return $this->handleResponse($application, 'Application is successfully created!', 201);
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function update(ApplicationRequest $request, $id) {
        try {
            $user = Auth::user();
            $role = strtolower(trim((string) $user->role));
            $query = Application::where('id', $id);

            // Employer can only update applications for their own jobs
            if ($role === 'employer') {
                $query->whereHas('job.company', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            } elseif ($role === 'user') {
                // Candidate can only update own application
                $query->where('user_id', $user->id);
            }

            $application = $query->first();

            if (!$application) {
                return $this->handleErrorResponse(null, "Application with ID:{$id} not found", 404);
            }

            $data = $request->validated();

            if (in_array($role, ['admin', 'employer'], true)) {
                // Reviewer fields
                $application->update([
                    'status' => $data['status'] ?? $application->status,
                    'employer_note' => $data['employer_note'] ?? $application->employer_note,
                    'reviewed_at' => $data['reviewed_at'] ?? now()->toDateString(),
                ]);
            } else {
                // Candidate fields only
                $application->update([
                    'cover_letter' => $data['cover_letter'] ?? $application->cover_letter,
                ]);
            }

            return $this->handleResponse($application, 'Application is successfully updated!');
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function delete($id) {
        try {
            $user = Auth::user();

            $query = Application::where('id', $id);

            if ($user->role === 'employer') {
                $query->whereHas('job.company', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            } elseif ($user->role === 'user') {
                $query->where('user_id', $user->id);
            }

            $application = $query->first();

            if (!$application) {
                return $this->handleErrorResponse(null, "Application with ID:{$id} not found", 404);
            }

            $application->delete();

            return $this->handleResponse(null, "Application is successfully deleted!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }
}
