<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobCategoryRequest;
use App\Models\JobCategory;

class JobCategoryController extends Controller
{
    public function index() {
        try {
            $jobCategories = JobCategory::orderBy('id', 'asc')->get();

            if($jobCategories->isEmpty()) {
                return $this->handleErrorResponse(null, "Job Categories is empty", 404);
            }

            return $this->handleResponse($jobCategories, "Job Categories is successfully received!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function show($id) {
        try {
            $jobCategory = JobCategory::find($id);

            if(!$jobCategory) {
                return $this->handleErrorResponse(null, "Job Category is not found", 404);
            }

            return $this->handleResponse($jobCategory, 'Job Category with ID:' . $id . ' is successfully received!');
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function create(JobCategoryRequest $request) {
        try {
            $jobCategory = JobCategory::create([
                'name' => $request->name
            ]);

            if(!$jobCategory) {
                return $this->handleErrorResponse(null, "Failed to create Job Category!", 404);
            }

            return $this->handleResponse($jobCategory, 'Job Category is successfully created!');
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function update(JobCategoryRequest $request, $id) {
        try {
            $jobCategory = JobCategory::find($id);

            if(!$jobCategory) {
                return $this->handleErrorResponse(null, "Job Category is not found!", 404);
            }

            $jobCategory->update([
                'name' => $request->name
            ]);

            return $this->handleResponse($jobCategory, 'Job Category is successfully updated!');
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function delete($id) {
        try {
            $jobCategory = JobCategory::find($id);

            if(!$jobCategory) {
                return $this->handleErrorResponse(null, "Job Category is not found!", 404);
            }

            $jobCategory->delete();

            return $this->handleResponse(null, 'Job Category is successfully deleted!');
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }
}
