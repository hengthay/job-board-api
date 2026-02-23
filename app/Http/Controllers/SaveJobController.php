<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveJobRequest;
use App\Models\SaveJob;
use Illuminate\Support\Facades\Auth;

class SaveJobController extends Controller
{
    public function index() {
        try {
            $userId = Auth::user()->id;
            $saveJobs = SaveJob::where('user_id', $userId)
                        ->get();

            if ($saveJobs->isEmpty()) {
                return $this->handleErrorResponse(null, "Save Job is currently empty!", 404);
            }

            return $this->handleResponse($saveJobs, "Save Job is successfully received!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function show($id) {
        try {
            $userId = Auth::user()->id;
            $saveJob = SaveJob::where('id', $id)
                                ->where('user_id', $userId)
                                ->first();
            if(!$saveJob) {
                return $this->handleErrorResponse(null, "Save Job with ID:{$id} is not found!", 404);
            }

            return $this->handleResponse($saveJob, "Save Job with ID:{$id} is successfully received!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function create(SaveJobRequest $request) {
        try {
            $userId = Auth::user()->id;
            $saveJob = SaveJob::create([
                "user_id" => $userId,
                "job_id" => $request->job_id,
            ]);

            if(!$saveJob) {
                return $this->handleErrorResponse(null, "Failed to created Save Job!");
            }

            return $this->handleResponse($saveJob, "Save Job is successfully created!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function update(SaveJobRequest $request, $id) {
        try {
            $userId = Auth::user()->id;
            $saveJob = SaveJob::where('id', $id)
                                ->where('user_id', $userId)
                                ->first();
            
            if (!$saveJob) {
                return $this->handleErrorResponse(null, "Save Job not found to updated!", 404);
            }

            $saveJob->update([
                "user_id" => $userId,
                "job_id" => $request->job_id,
            ]);

            return $this->handleResponse($saveJob, "Save Job is successfully updated!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function delete($id) {
        try {
            $userId = Auth::user()->id;
            $saveJob = SaveJob::where('id', $id)
                                ->where('user_id', $userId)
                                ->first();
            
            if (!$saveJob) {
                return $this->handleErrorResponse(null, "Save Job not found to deleted!", 404);
            }

            $saveJob->delete();
            
            return $this->handleResponse(null, "Save Job is successfully deleted!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }
}
