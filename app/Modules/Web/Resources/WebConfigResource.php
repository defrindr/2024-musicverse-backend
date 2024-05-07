<?php

namespace App\Modules\Web\Resources;

use App\Models\Web\WebConfig;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WebConfigResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $parent = parent::toArray($request);
        if ($this->type == 'image') {
            $parent['value'] = asset_storage(WebConfig::FOLDER_PATH.'/'.$this->value);
        }

        return $parent;
    }
}
