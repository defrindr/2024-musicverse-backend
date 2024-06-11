<?php

namespace App\Modules\Audition\Resources;

use App\Models\Audition\Audition;
use App\Models\Audition\SkillCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuditionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $parent = parent::toArray($request);

        $parent['term'] = asset("storage/" . Audition::UPLOADED_PATH . $parent['term']);
        $parent['contract'] = asset("storage/" . Audition::UPLOADED_PATH . $parent['contract']);
        $parent['skill'] = new SkillCategoryListResource(SkillCategory::whereId($this->skill_id)->first());
        $parent['date'] = date("d F Y H:i", strtotime($this->date));
        $parent['_date'] = $this->date;

        return $parent;
    }
}
