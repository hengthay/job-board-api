<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobTypeRequest;
use App\Models\JobType;

class JobTypeController extends Controller
{
    public function index() {
        try {
            $jobTypes = JobType::orderBy('id', 'asc')->get();

            if($jobTypes->isEmpty()) {
                return $this->handleErrorResponse(null, "Job Types is empty", 404);
            }

            return $this->handleResponse($jobTypes, "Job Types is successfully received!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function show($id) {
        try {
            $jobType = JobType::find($id);

            if(!$jobType) {
                return $this->handleErrorResponse(null, "Job Type with ID: " . $id . ' is not found!', 404);
            }

            return $this->handleResponse($jobType, 'Job Type with ID:' . $id . ' is successfully received!');
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function create(JobTypeRequest $request) {
        try {
            $jobType = JobType::create([
                'name' => $request->name
            ]);

            if(!$jobType) {
                return $this->handleErrorResponse(null, "Failed to create Job Type!", 404);
            }

            return $this->handleResponse($jobType, 'Job Category is successfully created!');
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function update(JobTypeRequest $request, $id) {
        try {
            $jobType = JobType::find($id);

            if(!$jobType) {
                return $this->handleErrorResponse(null, "Job Type is not found!", 404);
            }

            $jobType->update([
                'name' => $request->name
            ]);

            return $this->handleResponse($jobType, 'Job Type is successfully updated!');
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function delete($id) {
        try {
            $jobType = JobType::find($id);

            if(!$jobType) {
                return $this->handleErrorResponse(null, "Job Type is not found!", 404);
            }

            $jobType->delete();

            return $this->handleResponse(null, 'Job Type is successfully deleted!');
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }
}
