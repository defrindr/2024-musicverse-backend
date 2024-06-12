<?php

namespace App\Modules\Master\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Master\Requests\LanguageStoreRequest;
use App\Modules\Master\Requests\LanguageUpdateRequest;
use App\Modules\Master\Services\LanguageService;
use Defrindr\Crudify\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Auto-generated LanguageController
 *
 * @author defrindr
 */
class LanguageController extends Controller
{
    protected LanguageService $service;

    public function __construct()
    {
        $this->service = new LanguageService();
    }

    public function index(Request $request): JsonResponse
    {
        return ResponseHelper::successWithData($this->service->list($request->all()));
    }

    public function show(int $id): JsonResponse
    {
        try {
            return ResponseHelper::successWithData($this->service->getById($id));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return ResponseHelper::error($th, 'Terjadi kesalahan saat menjalankan aksi');
        }
    }

    public function store(LanguageStoreRequest $request): JsonResponse
    {
        try {
            $success = $this->service->store($request->validated());

            if ($success) {
                return ResponseHelper::successWithData(null, 'Resource berhasil dibuat', 201);
            } else {
                return ResponseHelper::badRequest('Resource gagal dibuat');
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return ResponseHelper::error($th, 'Terjadi kesalahan saat menjalankan aksi');
        }
    }

    public function update(LanguageUpdateRequest $request, int $id): JsonResponse
    {
        try {
            $success = $this->service->update($id, $request->validated());

            if ($success) {
                return ResponseHelper::successWithData(null, 'Resource berhasil diubah');
            } else {
                return ResponseHelper::badRequest('Resource gagal diubah');
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return ResponseHelper::error($th, 'Terjadi kesalahan saat menjalankan aksi');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $success = $this->service->destroy($id);

            if ($success) {
                return ResponseHelper::successWithData(null, 'Resource berhasil dihapus');
            } else {
                return ResponseHelper::badRequest('Resource gagal dihapus');
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return ResponseHelper::error($th, 'Terjadi kesalahan saat menjalankan aksi');
        }
    }
}
