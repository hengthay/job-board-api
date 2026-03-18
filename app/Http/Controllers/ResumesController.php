<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResumeRequest;
use App\Models\CandidateProfile;
use App\Models\Resumes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ResumesController extends Controller
{
    public function index() {
        try {
            $userId = Auth::user()->id;

            $resumes = Resumes::where('user_id', $userId)
                            ->orderBy("id", 'asc')->get();

            if($resumes->isEmpty()) {
                return $this->handleErrorResponse(null, 'Resume is empty!', 404);
            }

            return $this->handleResponse($resumes, 'Resume is successfully received!');
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function show($id) {
        try {
            $userId = Auth::user()->id;
            $resume = Resumes::where('user_id', $userId)
                        ->where('id', $id)
                        ->first();

            if(!$resume) {
                return $this->handleErrorResponse(null, 'Resume with ID:' . $id . ' is not found!' , 404);
            }

            return $this->handleResponse($resume, 'Resume is successfully received!');
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function create(ResumeRequest $request) {
        try {
            $userId = Auth::user()->id;
            $file_path = null;
            $file = $request->file('file_path');
            $fileName = $file->getClientOriginalName();
            $mimeType = $file->getClientMimeType();

            if($request->hasFile('file_path')) {
                $file_path = $request->file('file_path')->store('resumes', 'public');
            }

            $resume = Resumes::create([
                'user_id' => $userId,
                "file_path" => $file_path,
                "file_name" => $fileName,
                "mime_type" => $mimeType,
                "is_default" => $request->is_default,
            ]);

            if (!$resume) {
                return $this->handleErrorResponse(null, 'Failed to created resume!', 404);
            }
            
            // Log::debug('profile data', [
            //     'profile' => $profile
            // ]);

            return $this->handleResponse($resume, 'Resume created and linked to profile successfully!');
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function update(ResumeRequest $request, $id) {
        try {
            $userId = Auth::user()->id;
            $resume = Resumes::find($id);
            $data = $request->validated();

            if (!$resume) {
                return $this->handleErrorResponse(null, 'Resume with ID:' . $id . ' is not found!', 404);
            }

            if ($request->hasFile('file_path')) {
                $file = $request->file('file_path');

                if($resume->file_path && Storage::disk('public')->exists($resume->file_path)) {
                    Storage::disk('public')->delete($resume->file_path);
                }

                $data['file_path'] = $request->file('file_path')->store('resumes', 'public');
                $data['file_name'] = $file->getClientOriginalName();
                $data['mime_type'] = $file->getClientMimeType();
            }
            $data['user_id'] = $userId;
            $resume->update($data);

            return $this->handleResponse($resume, 'Resume is successfully updated!');
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function delete($id) {
        try {
            $userId = Auth::user()->id;
            $resume = Resumes::where('user_id', $userId)->find($id);
            
            if (!$resume) {
                return $this->handleErrorResponse(null, 'Resume with ID:' . $id . ' is not found!', 404);
            }

            // Delete physical file from storage before deleting from DB
            if ($resume->file_path) {
                // Force disk to public and check path
                if (Storage::disk('public')->exists($resume->file_path)) {
                    Storage::disk('public')->delete($resume->file_path);
                }
            }
            
            $resume->delete();

            return $this->handleResponse(null, 'Resume is successfully updated!');
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }
}
