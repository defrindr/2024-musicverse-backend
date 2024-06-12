<?php

namespace App\Modules\Web\Services;

use App\Models\Web\WebFaq;
use App\Modules\Web\Resources\WebFaqResource;
use Defrindr\Crudify\Exceptions\NotFoundHttpException;
use Defrindr\Crudify\Helpers\PaginationHelper;
use Defrindr\Crudify\Resources\PaginationCollection;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Kelas untuk handling bisnis proses
 * auto-generated WebFaqService
 *
 * @author defrindr
 */
class WebFaqService
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
        $builder = WebFaq::query();
        $pagination = $builder
            ->orderBy(
                $this->paginator->resolveSortColumn($payload, WebFaq::getTableColumns()),
                $this->paginator->resolveSortDirection($payload)
            )
            ->search($this->paginator->resolveGlobalSearch($payload))
            ->paginate($this->paginator->resolveLimit($payload));

        return new PaginationCollection($pagination, WebFaqResource::class);
    }

    /**
     * Mendapatkan resource by id
     */
    public function getById(int $id): JsonResource
    {
        $resource = self::has($id);

        return new WebFaqResource($resource);
    }

    /**
     * Menyimpan payload ke database
     */
    public function store(array $payload): bool
    {
        return WebFaq::create($payload) ? true : false;
    }

    /**
     * Menyimpan perubahan payload ke database sesuai dengan resource yang dipilih
     */
    public function update(int $id, array $payload): bool
    {
        $resource = self::has($id);
        $payload = array_filter($payload, 'strlen');

        return $resource->update($payload) ? true : false;
    }

    /**
     * Menghapus aksi dari database
     */
    public function destroy(int $id): bool
    {
        $resource = self::has($id);

        return $resource->delete();
    }

    public function has(int $id): WebFaq
    {
        $resource = WebFaq::find($id);
        if (! $resource) {
            throw new NotFoundHttpException("Resource #{$id} tidak ditemukan.");
        }

        return $resource;
    }
}
