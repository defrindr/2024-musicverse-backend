<?php

namespace App\Modules\Audition\Requests;

use Defrindr\Crudify\Requests\FormRequest;

/**
 * Auto-generated SkillCategoryUpdateRequest
 *
 * @author defrindr
 */
class SkillCategoryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'icon' => 'file|mimes:png,gif,pjg,jpeg,webp',
            'name' => 'required|unique:skill_categories,name,'.request()->id,
        ];

        return $rules;
    }
}
