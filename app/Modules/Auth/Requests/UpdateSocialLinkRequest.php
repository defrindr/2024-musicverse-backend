<?php

namespace App\Modules\Auth\Requests;

use App\Models\SocialLink;
use Defrindr\Crudify\Requests\FormRequest;

class UpdateSocialLinkRequest extends FormRequest
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
            'socials.*.name' => 'required:in:' . implode(",", SocialLink::ALLOWED_NAMES),
            'socials.*.value' => 'nullable|url',
        ];
    }

    public function messages()
    {
        $messages = ['required' => ':attribute tidak boleh kosong'];
        $socials = request()->get('socials');

        foreach ($socials as $index => $social) {
            $messages["socials.$index.value.url"] = ucwords($social['name']) . ' harus berupa url yang valid';
        }
        return $messages;
    }
}
