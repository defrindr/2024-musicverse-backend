<?php

namespace App\Modules\Audition\Controllers;

use Defrindr\Crudify\Helpers\PaginationHelper;
use Defrindr\Crudify\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Modules\Audition\Requests\AuditionAssesmentStoreRequest;
use App\Modules\Audition\Requests\AuditionAssesmentUpdateRequest;
use App\Modules\Audition\Services\AuditionAssesmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


/**
 * Auto-generated AuditionAssesmentController
 * @author defrindr
 */

class AuditionAssesmentController extends Controller
{
    protected AuditionAssesmentService $service;

    public function __construct()
    {
        $this->service = new AuditionAssesmentService();
    }

    public function index(Request $request, int $auditionId): JsonResponse
    {
        return ResponseHelper::successWithData($this->service->list($request->all(), $auditionId));
    }

    public function show(int $auditionId, int $id): JsonResponse
    {
        try {
            return ResponseHelper::successWithData($this->service->getById($auditionId, $id));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return ResponseHelper::error($th, 'Terjadi kesalahan saat menjalankan aksi');
        }
    }

    public function store(AuditionAssesmentStoreRequest $request, int $auditionId): JsonResponse
    {
        try {
            $success = $this->service->store($auditionId, $request->validated());

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

    public function update(AuditionAssesmentUpdateRequest $request, int $auditionId, int $id): JsonResponse
    {
        try {
            $success = $this->service->update($auditionId, $id, $request->validated());

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

    public function destroy(int $auditionId, int $id): JsonResponse
    {
        try {
            $success = $this->service->destroy($auditionId, $id);

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
