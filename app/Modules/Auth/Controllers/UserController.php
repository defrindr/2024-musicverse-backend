<?php

namespace App\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Services\UserService;
use Defrindr\Crudify\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Auto-generated UserController
 *
 * @author defrindr
 */
class UserController extends Controller
{
    protected UserService $service;

    public function __construct()
    {
        $this->service = new UserService();
    }

    public function index(Request $request, string $role): JsonResponse
    {
        return ResponseHelper::successWithData($this->service->listWithRole($role, $request->all()));
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
}
