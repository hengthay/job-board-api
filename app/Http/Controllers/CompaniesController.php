<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompaniesRequest;
use App\Models\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompaniesController extends Controller
{
    public function index() {
        try {
            $companies = Companies::orderBy('id', 'asc')->get();

            if ($companies->isEmpty()) {
                return $this->handleErrorResponse(null, "All Companies is empty!", 404);
            }

            return $this->handleResponse($companies, "All Companies is successfully received!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function findCompany($id) {
        try {
            $company = Companies::where('id', $id)
                            ->orderBy('id', 'asc')
                            ->get();

            if ($company->isEmpty()) {
                return $this->handleErrorResponse(null, "Company with ID:{$id} is not found!", 404);
            }

            return $this->handleResponse($company, "Company with ID:{$id} is successfully received!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function show($id) {
        try {
            $userId = Auth::user()->id;
            $company = Companies::where('user_id', $userId)
                            ->where('id', $id)
                            ->first();
            
            if (!$company) {
                return $this->handleErrorResponse(null, "Company with ID:{$id} is not found!", 404);
            }

            return $this->handleResponse($company, "Company with ID:{$id} is successfully retrived!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function create(CompaniesRequest $request) {
        try {
            $userId = Auth::user()->id;
            $imagePath = null;

            if ($request->hasFile('logo_path')) {
                $imagePath = $request->file('logo_path')->store('companies', 'public');
            }

            $company = Companies::create([
                "user_id" => $userId,
                "name" => $request->name,
                "slug" => $request->slug,
                "logo_path" => $imagePath,
                "website_url" => $request->website_url,
                "industry" => $request->industry,
                "company_size" => $request->company_size,
                "location" => $request->location,
                "description" => $request->description,
                "verified_at" => $request->verified_at
            ]);

            if (!$company) {
                return $this->handleErrorResponse(null, "Failed to updated Company!", 404);
            }

            return $this->handleResponse($company, "Company is updated successfully!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function update(CompaniesRequest $request, $id) {
        try {
            $userId = Auth::user()->id;
            $company = Companies::find($id);
            $imagePath = null;

            if (!$company) {
                return $this->handleErrorResponse(null, "Company with ID:{$id} is not found to update!", 404);
            }

            if ($request->hasFile('logo_path')) {

                if ($request->logo_path && Storage::disk('public')->exists($request->logo_path)) {
                    Storage::disk('public')->delete($request->logo_path);
                }

                $imagePath = $request->file('logo_path')->store('companies', 'public');
            }

            $company->update([
                "user_id" => $userId,
                "name" => $request->name,
                "slug" => $request->slug,
                "logo_path" => $imagePath,
                "website_url" => $request->website_url,
                "industry" => $request->industry,
                "company_size" => $request->company_size,
                "location" => $request->location,
                "description" => $request->description,
                "verified_at" => $request->verified_at
            ]);

            return $this->handleResponse($company, "Company is updated successfully!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function delete($id) {
        try {
            $userId = Auth::user()->id;
            $company = Companies::where('user_id', $userId)
                            ->where('id', $id)
                            ->first();
            
            if (!$company) {
                return $this->handleErrorResponse(null, "Company with ID:{$id} is not found to delete!", 404);
            }

            $company->delete();

            return $this->handleResponse(null, "Company with ID:{$id} is successfully deleted!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function adminDelete($id) {
        try {
            $company = Companies::find($id);

            if(!$company) {
                return $this->handleErrorResponse(null, "Company with ID:{$id} is not found for admin to delete!");
            }

            $company->delete();

            return $this->handleResponse(null, "Company with ID:{$id} is successfully deleted by Admin!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }
}
