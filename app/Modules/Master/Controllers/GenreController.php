<?php

namespace App\Modules\Master\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Master\Requests\GenreStoreRequest;
use App\Modules\Master\Requests\GenreUpdateRequest;
use App\Modules\Master\Services\GenreService;
use Defrindr\Crudify\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Auto-generated GenreController
 *
 * @author defrindr
 */
class GenreController extends Controller
{
    protected GenreService $service;

    public function __construct()
    {
        $this->service = new GenreService();
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

    public function store(GenreStoreRequest $request): JsonResponse
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

    public function update(GenreUpdateRequest $request, int $id): JsonResponse
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
