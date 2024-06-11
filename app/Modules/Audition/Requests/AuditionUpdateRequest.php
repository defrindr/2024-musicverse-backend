<?php

namespace App\Modules\Audition\Requests;

use Defrindr\Crudify\Requests\FormRequest;

/**
 * Auto-generated AuditionUpdateRequest
 *
 * @author defrindr
 */
class AuditionUpdateRequest extends FormRequest
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
            'title' => 'required',
            'skill_id' => 'required',
            'date' => 'required',
            // 'created_by' => 'required',
            'description' => 'required',
            'term' => 'nullable|file|mimes:pdf',
            'contract' => 'nullable|file|mimes:pdf',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute tidak boleh kosong',
        ];
    }
}
