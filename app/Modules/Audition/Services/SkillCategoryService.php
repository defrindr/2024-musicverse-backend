<?php

namespace App\Modules\Audition\Services;

use App\Models\Audition\SkillCategory;
use App\Modules\Audition\Resources\SkillCategoryListResource;
use Defrindr\Crudify\Exceptions\BadRequestHttpException;
use Defrindr\Crudify\Exceptions\NotFoundHttpException;
use Defrindr\Crudify\Helpers\PaginationHelper;
use Defrindr\Crudify\Helpers\RequestHelper;
use Defrindr\Crudify\Resources\PaginationCollection;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Kelas untuk handling bisnis proses
 * auto-generated SkillCategoryService
 *
 * @author defrindr
 */
class SkillCategoryService
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
        $builder = SkillCategory::query();
        $pagination = $builder
            ->orderBy(
                $this->paginator->resolveSortColumn($payload, SkillCategory::getTableColumns()),
                $this->paginator->resolveSortDirection($payload)
            )
            ->search($this->paginator->resolveGlobalSearch($payload))
            ->paginate($this->paginator->resolveLimit($payload));

        return new PaginationCollection($pagination, SkillCategoryListResource::class);
    }

    /**
     * Mendapatkan resource by id
     */
    public function getById(int $id): JsonResource
    {
        $resource = self::has($id);

        return new SkillCategoryListResource($resource);
    }

    /**
     * Menyimpan payload ke database
     */
    public function store(array $payload): bool
    {
        $this->handleUploadFile($payload);

        return SkillCategory::create($payload) ? true : false;
    }

    /**
     * Menyimpan perubahan payload ke database sesuai dengan resource yang dipilih
     */
    public function update(int $id, array $payload): bool
    {
        $resource = self::has($id);
        $payload = array_filter($payload, 'strlen');
        $this->handleUploadFile($payload, false, $resource->icon);

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

    public function dropdown(array $payload)
    {
        $selected = null;
        if (isset($payload['selected'])) {
            $item = SkillCategory::whereId($payload['selected'])->first();
            $selected = [
                'key' => $item->id,
                'label' => $item->name,
            ];
        }
        $items = [];
        $model = SkillCategory::query();

        if (isset($payload['search'])) {
            $model->search($payload['search'] ?? '');
        }

        $model = $model->paginate(10);

        foreach ($model as $item) {
            array_push($items, [
                'key' => $item->id,
                'label' => $item->name,
            ]);
        }

        return compact('selected', 'items');
    }

    public function has(int $id): SkillCategory
    {
        $resource = SkillCategory::find($id);
        if (! $resource) {
            throw new NotFoundHttpException("Resource #{$id} tidak ditemukan.");
        }

        return $resource;
    }

    private function handleUploadFile(&$payload, $required = true, $oldFile = null)
    {
        if ($required === false) {
            if (! isset($payload['icon']) || ! $payload['icon']) {
                unset($payload['icon']);

                return;
            }
        }

        $response = RequestHelper::uploadFile($payload['icon'], SkillCategory::UPLOADED_PATH, $oldFile);
        if (! $response['success']) {
            throw new BadRequestHttpException('Terjadi kesalahan saat mengunggah ikon');
        }
        $payload['icon'] = $response['fileName'];
    }
}
