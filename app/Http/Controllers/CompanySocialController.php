<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanySocialRequest;
use App\Models\CompanySocial;
use Illuminate\Http\Request;

class CompanySocialController extends Controller
{
    public function index() {
        try {
            $companySocials = CompanySocial::orderBy('id', 'asc')->get();

            if($companySocials->isEmpty()) {
                return $this->handleErrorResponse(null, "Company Social is empty!", 404);
            }

            return $this->handleResponse($companySocials, 'All Company Social is successfully received!');
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }
    public function findCompanySocial($id) {
        try {
            $companySocials = CompanySocial::find($id);

            if(!$companySocials) {
                return $this->handleErrorResponse(null, "Company Social with ID:{$id} is not found!", 404);
            }

            return $this->handleResponse($companySocials, "Company Social With ID:{$id} successfully received by Admin!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }
    public function show($id) {
        try {
            $companySocials = CompanySocial::find($id);

            if(!$companySocials) {
                return $this->handleErrorResponse(null, "Company Social with ID:{$id} is not found!", 404);
            }

            return $this->handleResponse($companySocials, "Company Social With ID:{$id} successfully received!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function create(CompanySocialRequest $request) {
        try {
            $companySocial = CompanySocial::create([
                "company_id" => $request->company_id,
                "platform" => $request->platform,
                "url" => $request->url
            ]);

            if(!$companySocial) {
                return $this->handleErrorResponse(null, "Failed to created Company Social!", 404);
            }

            return $this->handleResponse($companySocial, "Company Social is successfully created!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function update(CompanySocialRequest $request, $id) {
        try {
            $companySocial = CompanySocial::find($id);

            if(!$companySocial) {
                return $this->handleErrorResponse(null, "Company Social with ID:{$id} is not found to updated!", 404);
            }

            $companySocial->update([
                "company_id" => $request->company_id,
                "platform" => $request->platform,
                "url" => $request->url
            ]);

            return $this->handleResponse($companySocial, "Company Social is successfully updated!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function delete($id) {
        try {
            $companySocial = CompanySocial::find($id);

            if(!$companySocial) {
                return $this->handleErrorResponse(null, "Company Social with ID:{$id} is not found to deleted!", 404);
            }

            $companySocial->delete();

            return $this->handleResponse(null, "Company Social is successfully deleted!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }

    public function adminDelete($id) {
        try {
            $companySocial = CompanySocial::find($id);

            if(!$companySocial) {
                return $this->handleErrorResponse(null, "Company Social with ID:{$id} is not found to deleted!", 404);
            }

            $companySocial->delete();

            return $this->handleResponse(null, "Company Social is successfully deleted by Admin!");
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, $e->getMessage(), 500);
        }
    }
}
