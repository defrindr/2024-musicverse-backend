<?php

namespace App\Modules\Audition\Resources;

use App\Models\Audition\SkillCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SkillCategoryListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $parent = parent::toArray($request);

        $parent['icon'] = asset("storage/" . SkillCategory::UPLOADED_PATH . $parent['icon']);
        return $parent;
    }
}
