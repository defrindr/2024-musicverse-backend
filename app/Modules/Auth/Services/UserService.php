<?php

namespace App\Modules\Auth\Services;

use App\Models\User;
use App\Modules\Auth\Resources\UserResource;
use Defrindr\Crudify\Exceptions\NotFoundHttpException;
use Defrindr\Crudify\Helpers\PaginationHelper;
use Defrindr\Crudify\Resources\PaginationCollection;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Kelas untuk handling bisnis proses
 * auto-generated UserService
 *
 * @author defrindr
 */
class UserService
{
    private $paginator;

    public function __construct()
    {
        $this->paginator = new PaginationHelper();
    }

    /**
     * Mengambil paginasi data dari resources
     */
    public function list(array $payload): JsonResource
    {
        $builder = User::query();

        $builder->whereNotIn('role', [User::ROLE_ADMIN, User::ROLE_REGISTER]);

        $pagination = $builder
            ->orderBy(
                $this->paginator->resolveSortColumn($payload, User::getTableColumns()),
                $this->paginator->resolveSortDirection($payload)
            )
            ->search($this->paginator->resolveGlobalSearch($payload))
            ->paginate($this->paginator->resolveLimit($payload));

        return new PaginationCollection($pagination, UserResource::class);
    }

    /**
     * Mengambil paginasi data dari resources
     */
    public function listWithRole(string $role, array $payload): JsonResource
    {
        $builder = User::query();
        $builder->where('role', $role);

        $pagination = $builder
            ->orderBy(
                $this->paginator->resolveSortColumn($payload, User::getTableColumns()),
                $this->paginator->resolveSortDirection($payload)
            )
            ->search($this->paginator->resolveGlobalSearch($payload))
            ->paginate($this->paginator->resolveLimit($payload));

        return new PaginationCollection($pagination, UserResource::class);
    }

    /**
     * Mendapatkan resource by id
     */
    public function getById(int $id): JsonResource
    {
        $resource = self::has($id);

        return new UserResource($resource);
    }

    public function has(int $id): User
    {
        $resource = User::find($id);
        if (! $resource) {
            throw new NotFoundHttpException("Resource #{$id} tidak ditemukan.");
        }

        return $resource;
    }
}
