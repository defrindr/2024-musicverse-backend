<?php

namespace App\Modules\Audition\Requests;

use Defrindr\Crudify\Requests\FormRequest;

/**
 * Auto-generated AuditionAssesmentStoreRequest
 *
 * @author defrindr
 */
class AuditionAssesmentStoreRequest extends FormRequest
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
            'assesment' => 'required',
            'weight' => 'required|numeric|min:0|max:100',
        ];
    }
}
