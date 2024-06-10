<?php

namespace App\Modules\Audition\Controllers;

use Defrindr\Crudify\Helpers\PaginationHelper;
use Defrindr\Crudify\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Modules\Audition\Requests\SkillCategoryStoreRequest;
use App\Modules\Audition\Requests\SkillCategoryUpdateRequest;
use App\Modules\Audition\Services\SkillCategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


/**
 * Auto-generated SkillCategoryController
 * @author defrindr
 */

class SkillCategoryController extends Controller
{
    protected SkillCategoryService $service;

    public function __construct()
    {
        $this->service = new SkillCategoryService();
    }

    public function index(Request $request): JsonResponse
    {
        return ResponseHelper::successWithData($this->service->list($request->all()));
    }

    public function store(SkillCategoryStoreRequest $request): JsonResponse
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

    public function update(SkillCategoryUpdateRequest $request, int $id): JsonResponse
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
