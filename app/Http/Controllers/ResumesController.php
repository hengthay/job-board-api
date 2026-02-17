<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResumeRequest;
use App\Models\Resumes;
use Illuminate\Support\Facades\Auth;
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
                        ->find($id);

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

            if($request->hasFile('file_path')) {
                $file_path = $request->file('file_path')->store('resumes', 'public');
            }

            $resume = Resumes::create([
                'user_id' => $userId,
                "file_path" => $file_path,
                "file_name" => $request->file_name,
                "mime_type" => $request->mime_type,
                "is_default" => $request->is_default,
            ]);

            if (!$resume) {
                return $this->handleErrorResponse(null, 'Failed to created resume!', 404);
            }

            return $this->handleResponse($resume, 'Resume is successfully created!');
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
                if($resume->file_path && Storage::disk('public')->exists($resume->file_path)) {
                    Storage::disk('public')->delete($resume->file_path);
                }

                $data['file_path'] = $request->file('file_path')->store('resumes', 'public');
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
            $resume = Resumes::find($id);
            
            if (!$resume) {
                return $this->handleErrorResponse(null, 'Resume with ID:' . $id . ' is not found!', 404);
            }

            $resume->delete();

            return $this->handleResponse(null, 'Resume is successfully updated!');
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }
}
