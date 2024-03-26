<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageVerifikasiRequest extends FormRequest
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
            'image_1' => 'required|image',
            'image_2' => 'required|image',
            'image_3' => 'required|image',
            'image_4' => 'required|image',
        ];
    }
}
