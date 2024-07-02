<?php

namespace App\Modules\Audition\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Audition\Services\AuditionParticipantService;
use Defrindr\Crudify\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Auto-generated AuditionParticipantController
 *
 * @author defrindr
 */
class AuditionParticipantController extends Controller
{
    protected AuditionParticipantService $service;

    public function __construct()
    {
        $this->service = new AuditionParticipantService();
    }

    public function index(Request $request, int $id): JsonResponse
    {
        return ResponseHelper::successWithData($this->service->list($id, $request->all()));
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

    public function apply(int $id): JsonResponse
    {
        $user = auth()->user();
        try {
            $success = $this->service->apply($id, $user);

            if ($success) {
                return ResponseHelper::successWithData(null, $success, 201);
            } else {
                return ResponseHelper::badRequest('Gagal melakukan pendaftaran sebagai peserta audisi');
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return ResponseHelper::error($th, 'Terjadi kesalahan saat menjalankan aksi');
        }
    }

    public function registered(int $id): JsonResponse
    {
        $user = auth()->user();
        try {
            $success = $this->service->isRegistered($id, $user);

            return ResponseHelper::successWithData($success);
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

    public function setRoom(int $id, int $participantId)
    {

        try {
            $success = $this->service->setRoom($id, $participantId);

            if ($success) {
                return ResponseHelper::successWithData(null, 'Berhasil membuat room');
            } else {
                return ResponseHelper::badRequest('Gagal membuat room');
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return ResponseHelper::error($th, 'Terjadi kesalahan saat menjalankan aksi');
        }
    }
}
