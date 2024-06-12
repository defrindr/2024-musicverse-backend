<?php

namespace App\Modules\Web\Services;

use App\Models\Web\WebConfig;
use App\Models\Web\WebFaq;
use App\Modules\Web\Resources\WebConfigResource;
use Defrindr\Crudify\Exceptions\NotFoundHttpException;
use Defrindr\Crudify\Helpers\RequestHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

/**
 * Kelas untuk handling bisnis proses
 * auto-generated WebConfigService
 *
 * @author defrindr
 */
class WebConfigService
{
    /**
     * Mengambil paginasi data dari resources
     */
    public function list(): array
    {
        $dataTexts = WebConfig::withType('text')->get();
        // $dataColors = WebConfig::withType('color')->get();
        $dataImages = WebConfig::withType('image')->get();

        return [
            'texts' => WebConfigResource::collection($dataTexts),
            // 'colors' => WebConfigResource::collection($dataColors),
            'images' => WebConfigResource::collection($dataImages),
        ];
    }

    /**
     * Mengambil paginasi data dari resources
     */
    public function preferences(): array
    {
        $data = WebConfig::get();

        $items = [];

        foreach ($data as $item) {
            if ($item->type == 'image') {
                $items[$item->name] = asset_storage(WebConfig::FOLDER_PATH.'/'.$item->value);
            } else {

                $items[$item->name] = $item->value;
            }
        }

        $items['faqs'] = WebFaq::get();

        return $items;
    }

    /**
     * Mendapatkan resource by id
     */
    public function getById(int $id): JsonResource
    {
        $resource = self::has($id);

        return new WebConfigResource($resource);
    }

    /**
     * Menyimpan perubahan payload ke database sesuai dengan resource yang dipilih
     */
    public function update(array $payload): bool
    {
        $items = $payload['items'];
        DB::beginTransaction();

        $success = true;
        foreach ($items as $item) {
            $resource = WebConfig::where('name', $item['name'])->first();

            if ($resource) {
                $success &= $resource->update($item);
            }
        }

        DB::commit();

        return $success;
    }

    /**
     * Menyimpan perubahan payload ke database sesuai dengan resource yang dipilih
     */
    public function updateImage(array $payload): bool
    {
        DB::beginTransaction();

        $success = true;
        if (isset($payload['image'])) {
            foreach ($payload['image'] as $file) {
                $resource = WebConfig::where('name', $file['name'])
                    ->where('type', 'image')
                    ->first();
                if ($resource && isset($file['value'])) {
                    $uploaded = RequestHelper::uploadFile($file['value'], WebConfig::FOLDER_PATH);
                    if ($uploaded['success']) {
                        $success &= $resource->update(['value' => $uploaded['fileName']]);
                    }
                }
            }
        }

        DB::commit();

        return $success;
    }

    /**
     * Menghapus aksi dari database
     */
    public function destroy(int $id): bool
    {
        $resource = self::has($id);

        return $resource->delete();
    }

    public function has(int $id): WebConfig
    {
        $resource = WebConfig::find($id);
        if (! $resource) {
            throw new NotFoundHttpException("Resource #{$id} tidak ditemukan.");
        }

        return $resource;
    }
}
