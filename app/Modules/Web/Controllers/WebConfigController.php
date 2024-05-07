<?php

namespace App\Modules\Web\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Web\Requests\WebConfigUpdateImageRequest;
use App\Modules\Web\Requests\WebConfigUpdateRequest;
use App\Modules\Web\Services\WebConfigService;
use Defrindr\Crudify\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

/**
 * Auto-generated WebConfigController
 *
 * @author defrindr
 */
class WebConfigController extends Controller
{
    protected WebConfigService $service;

    public function __construct()
    {
        $this->service = new WebConfigService();
    }

    public function index(): JsonResponse
    {
        return ResponseHelper::successWithData($this->service->list());
    }

    public function update(WebConfigUpdateRequest $request): JsonResponse
    {
        try {
            $success = $this->service->update($request->validated());

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

    public function updateImage(WebConfigUpdateImageRequest $request): JsonResponse
    {
        try {
            $success = $this->service->updateImage($request->validated());

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
}
