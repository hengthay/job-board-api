<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidateProfileRequest;
use App\Models\CandidateProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CandidateProfileController extends Controller
{
    public function index () {
        try {
            $profiles = CandidateProfile::orderBy('id', 'asc')->get();

            if($profiles->isEmpty()) {
                return $this->handleErrorResponse(null, "All Candidate Profile is not found!", 404);
            }

            return $this->handleResponse($profiles, "All Candidate profile is successfully received!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function findProfile($id) {
        try {
            $profile = CandidateProfile::where('id', $id)->get();

            if($profile->isEmpty()) {
                return $this->handleErrorResponse(null, "Candidate Profile with ID:" . $id . " is not found!", 404);
            }

            return $this->handleResponse($profile, "Candidate profile with ID:" . $id . " successfully received!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function show ($id) {
        try {
            $userId = Auth::user()->id;
            $profile = CandidateProfile::where('user_id', $userId)
                        ->where('id', $id)
                        ->get();

            if($profile->isEmpty()) {
                return $this->handleErrorResponse(null, "Candidate Profile with ID:" . $id . " is not found!", 404);
            }

            return $this->handleResponse($profile, "Candidate profile with ID:" . $id . " successfully received!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function create (CandidateProfileRequest $request) {
        try {
            $userId = Auth::user()->id;
            $imagePath = null;

            if ($request->hasFile('profile_image')) {
                $imagePath = $request->file('profile_image')->store('profiles', 'public');
            }

            $profile = CandidateProfile::create([
                "user_id" => $userId,
                "title" => $request->title,
                "profile_image" => $imagePath,
                "summary" => $request->summary,
                "location" => $request->location,
                "experience_years" => $request->experience_years,
                "portfolio_url" => $request->portfolio_url,
                "linkedin_url" => $request->linkedin_url,
                "github_url" => $request->github_url
            ]);

            if(!$profile) {
                return $this->handleErrorResponse(null, "Failed to create Candidate Profile!", 404);
            }

            return $this->handleResponse($profile, "Candidate profile is successfully created!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function update (CandidateProfileRequest $request, $id) {
        try {
            $profile = CandidateProfile::find($id);
            $imagePath = null;
            if(!$profile) {
                return $this->handleErrorResponse(null, "Candidate profile with ID:" . $id. " is not found!", 404);
            }

            if ($request->hasFile('profile_image')) {
                if($profile->profile_image && Storage::disk('public')->exists($profile->profile_image)) {
                    Storage::disk('public')->delete($profile->profile_image);
                }

                $imagePath = $request->file('profile_image')->store('profiles', 'public');
            }

            $userId = Auth::user()->id;
            
            $profile->update([
                "user_id" => $userId,
                "title" => $request->title,
                "profile_image" => $imagePath,
                "summary" => $request->summary,
                "location" => $request->location,
                "experience_years" => $request->experience_years,
                "portfolio_url" => $request->portfolio_url,
                "linkedin_url" => $request->linkedin_url,
                "github_url" => $request->github_url
            ]);

            return $this->handleResponse($profile, "Candidate profile is successfully updated!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function delete ($id) {
        try {
            $userId = Auth::user()->id;

            $profile = CandidateProfile::where('id', $id)
                        ->where('user_id', $userId)
                        ->first();
                        
            if(!$profile) {
                return $this->handleErrorResponse(null, "Candidate profile with ID:" . $id. " is not found!", 404);
            }

            if ($profile->user_id !== $userId) {
                return $this->handleErrorResponse(
                    null,
                    "You are not allowed to delete this profile!",
                    403
                );
            }

            // Remove profile
            if($profile->profile_image && Storage::disk('public')->exists($profile->profile_image)) {
                Storage::disk('public')->delete($profile->profile_image);
            }
            
            $profile->delete();

            return $this->handleResponse(null, "Candidate profile is successfully delete!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function adminDelete($id)
    {
        try {
            // Admin can delete any profile
            $profile = CandidateProfile::find($id);

            if (!$profile) {
                return $this->handleErrorResponse(null, "Candidate profile with ID: {$id} not found!", 404);
            }

            // Remove profile image if exists
            if ($profile->profile_image &&
                Storage::disk('public')->exists($profile->profile_image)) {

                Storage::disk('public')->delete($profile->profile_image);
            }

            $profile->delete();

            return $this->handleResponse(null, "Candidate profile with ID: {$id} successfully deleted by admin.");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }
}
