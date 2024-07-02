<?php

namespace App\Modules\Audition\Services;

use App\Models\Audition\Audition;
use App\Models\Audition\AuditionParticipant;
use App\Models\User;
use App\Modules\Audition\Resources\AuditionResource;
use Defrindr\Crudify\Exceptions\BadRequestHttpException;
use Defrindr\Crudify\Exceptions\NotFoundHttpException;
use Defrindr\Crudify\Helpers\PaginationHelper;
use Defrindr\Crudify\Helpers\RequestHelper;
use Defrindr\Crudify\Resources\PaginationCollection;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Kelas untuk handling bisnis proses
 * auto-generated AuditionService
 *
 * @author defrindr
 */
class AuditionService
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
        $user = auth()->user();
        $builder = Audition::query();

        if ($user->role === User::ROLE_PRODUCER) {
            $builder->whereCreatedBy($user->id);
        }

        $pagination = $builder
            ->orderBy(
                $this->paginator->resolveSortColumn($payload, Audition::getTableColumns()),
                $this->paginator->resolveSortDirection($payload)
            )
            ->search($this->paginator->resolveGlobalSearch($payload))
            ->paginate($this->paginator->resolveLimit($payload));

        return new PaginationCollection($pagination, AuditionResource::class);
    }

    /**
     * Mendapatkan resource by id
     */
    public function getById(int $id): JsonResource
    {
        $resource = self::has($id);

        return new AuditionResource($resource);
    }

    /**
     * Menyimpan payload ke database
     */
    public function store(array $payload): bool
    {
        $this->stamp($payload);
        $this->handleUploadFile($payload, 'term');
        $this->handleUploadFile($payload, 'contract');

        return Audition::create($payload) ? true : false;
    }

    /**
     * Menyimpan perubahan payload ke database sesuai dengan resource yang dipilih
     */
    public function update(int $id, array $payload): bool
    {
        $resource = self::has($id);
        $payload = array_filter($payload, 'strlen');

        $this->handleUploadFile($payload, 'term', false, $resource->term);
        $this->handleUploadFile($payload, 'contract', false, $resource->contract);

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

    public function has(int $id): Audition
    {
        $resource = Audition::find($id);
        if (! $resource) {
            throw new NotFoundHttpException("Resource #{$id} tidak ditemukan.");
        }

        return $resource;
    }

    private function stamp(&$payload)
    {
        $user = auth()->user();
        $payload['created_by'] = $user->id;
    }

    private function handleUploadFile(&$payload, $name, $required = true, $oldFile = null)
    {
        if ($required === false) {
            if (! isset($payload[$name]) || ! $payload[$name]) {
                unset($payload[$name]);

                return;
            }
        }

        $response = RequestHelper::uploadFile($payload[$name], Audition::UPLOADED_PATH, $oldFile);
        if (! $response['success']) {
            throw new BadRequestHttpException('Terjadi kesalahan saat mengunggah '.$name);
        }
        $payload[$name] = $response['fileName'];
    }

    public function getApply(User $user, array $payload)
    {
        $user = auth()->user();
        $subQuery = AuditionParticipant::where('participant_id', $user->id)->select('audition_id');
        $builder = Audition::whereIn('id', $subQuery);

        $pagination = $builder
            ->orderBy(
                $this->paginator->resolveSortColumn($payload, Audition::getTableColumns()),
                $this->paginator->resolveSortDirection($payload)
            )
            ->search($this->paginator->resolveGlobalSearch($payload))
            ->paginate($this->paginator->resolveLimit($payload));

        return new PaginationCollection($pagination, AuditionResource::class);
    }
}
