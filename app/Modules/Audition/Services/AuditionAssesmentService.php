<?php

namespace App\Modules\Audition\Services;

use Defrindr\Crudify\Helpers\PaginationHelper;
use Defrindr\Crudify\Exceptions\NotFoundHttpException;
use Defrindr\Crudify\Resources\PaginationCollection;
use App\Models\Audition\AuditionAssesment;
use App\Modules\Audition\Resources\AuditionAssesmentResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Kelas untuk handling bisnis proses
 * auto-generated AuditionAssesmentService
 * @author defrindr
 */
class AuditionAssesmentService
{
    private $paginator;
    public function __construct()
    {
        $this->paginator = new PaginationHelper();
    }

    /**
     * Mengambil paginasi data dari resources
     */
    public function list(array $payload, int $auditionId = null): JsonResource
    {
        $builder = AuditionAssesment::query();

        if ($auditionId) {
            $builder->whereAuditionId($auditionId);
        }

        $pagination = $builder
            ->orderBy(
                $this->paginator->resolveSortColumn($payload, AuditionAssesment::getTableColumns()),
                $this->paginator->resolveSortDirection($payload)
            )
            ->search($this->paginator->resolveGlobalSearch($payload))
            ->paginate($this->paginator->resolveLimit($payload));

        return new PaginationCollection($pagination, AuditionAssesmentResource::class);
    }

    /**
     * Mendapatkan resource by id
     */
    public function getById(int $auditionId, int $id): JsonResource
    {
        $resource = self::has($auditionId, $id);
        return new AuditionAssesmentResource($resource);
    }

    /**
     * Menyimpan payload ke database
     */
    public function store(int $auditionId, array $payload): bool
    {
        $payload['audition_id'] = $auditionId;
        return AuditionAssesment::create($payload) ? true : false;
    }

    /**
     * Menyimpan perubahan payload ke database sesuai dengan resource yang dipilih
     */
    public function update(int $auditionId, int $id, array $payload): bool
    {
        $resource = self::has($auditionId, $id);
        $payload = array_filter($payload, 'strlen');
        $payload['audition_id'] = $auditionId;

        return $resource->update($payload) ? true : false;
    }

    /**
     * Menghapus aksi dari database
     */
    public function destroy(int $auditionId, int $id): bool
    {
        $resource = self::has($auditionId, $id);

        return $resource->delete();
    }

    public function has(int $auditionId, int $id): AuditionAssesment
    {
        $resource = AuditionAssesment::whereId($id)->whereAuditionId($auditionId)->first();
        if (!$resource) {
            throw new NotFoundHttpException("Resource #{$id} tidak ditemukan.");
        }

        return $resource;
    }
}
