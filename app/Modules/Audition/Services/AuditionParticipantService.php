<?php

namespace App\Modules\Audition\Services;

use App\Models\Audition\AuditionParticipant;
use App\Models\User;
use App\Modules\Audition\Resources\AuditionParticipantResource;
use Defrindr\Crudify\Exceptions\BadRequestHttpException;
use Defrindr\Crudify\Exceptions\NotFoundHttpException;
use Defrindr\Crudify\Helpers\PaginationHelper;
use Defrindr\Crudify\Resources\PaginationCollection;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Kelas untuk handling bisnis proses
 * auto-generated AuditionParticipantService
 *
 * @author defrindr
 */
class AuditionParticipantService
{
    private $paginator;

    public function __construct()
    {
        $this->paginator = new PaginationHelper();
    }

    /**
     * Mengambil paginasi data dari resources
     */
    public function list(int $id, array $payload): JsonResource
    {
        $builder = AuditionParticipant::query()->where('audition_id', $id);
        $pagination = $builder
            ->orderBy(
                $this->paginator->resolveSortColumn($payload, AuditionParticipant::getTableColumns()),
                $this->paginator->resolveSortDirection($payload)
            )
            ->search($this->paginator->resolveGlobalSearch($payload))
            ->paginate($this->paginator->resolveLimit($payload));

        return new PaginationCollection($pagination, AuditionParticipantResource::class);
    }

    /**
     * Mendapatkan resource by id
     */
    public function getById(int $id): JsonResource
    {
        $resource = self::has($id);

        return new AuditionParticipantResource($resource);
    }

    /**
     * Menghapus aksi dari database
     */
    public function destroy(int $id): bool
    {
        $resource = self::has($id);

        return $resource->delete();
    }

    public function has(int $id): AuditionParticipant
    {
        $resource = AuditionParticipant::find($id);
        if (!$resource) {
            throw new NotFoundHttpException("Resource #{$id} tidak ditemukan.");
        }

        return $resource;
    }

    public function apply(int $idAudition, User $user): string
    {
        $payload = ['participant_id' => $user->id, 'audition_id' => $idAudition];

        if (AuditionParticipant::where($payload)->exists()) {
            $participant = AuditionParticipant::where(array_merge($payload, ['status' => AuditionParticipant::STATUS_REGISTER]))->first();
            if (!$participant) {
                throw new BadRequestHttpException('Data partisipan telah terdaftar pada audisi ini');
            }
            $participant->delete();

            return 'Berhasil membatalkan pendaftaran sebagai peserta audisi';
        }

        $participant = AuditionParticipant::create(array_merge($payload, ['status' => AuditionParticipant::STATUS_REGISTER]));

        if ($participant) {
            return 'Berhasil mendaftar sebagai peserta audisi';
        }

        return null;
    }

    public function isRegistered(int $id, User $user): array
    {
        $payload = ['participant_id' => $user->id, 'audition_id' => $id];

        $exists = AuditionParticipant::where($payload)->exists();

        return [
            'status' => $exists,
            'data' => $exists ? new AuditionParticipantResource(AuditionParticipant::where($payload)->first()) : null,
        ];
    }

    public function setRoom(int $id, int $participantId): true
    {
        $randomRoomKey = \Illuminate\Support\Str::random(32);
        $participant = AuditionParticipant::where(['audition_id' => $id, 'id' => $participantId])->first();

        if (!$participant) {
            throw new BadRequestHttpException(('Participant tidak dapat ditemukan'));
        }
        $participant->update(['room' => $randomRoomKey, 'status' => AuditionParticipant::STATUS_AUDITION]);

        return true;
    }
}
