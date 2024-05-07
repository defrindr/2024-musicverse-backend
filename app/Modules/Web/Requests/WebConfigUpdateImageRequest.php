<?php

namespace App\Modules\Web\Requests;

use Defrindr\Crudify\Requests\FormRequest;

/**
 * Auto-generated WebConfigUpdateRequest
 *
 * @author defrindr
 */
class WebConfigUpdateImageRequest extends FormRequest
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
        return [
            'image.*.name' => 'required',
            'image.*.value' => 'nullable',
        ];
    }
}