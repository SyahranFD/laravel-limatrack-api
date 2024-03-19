<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PedagangRequest extends FormRequest
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
            'nama_warung' => 'required|max:255',
            // 'image' => 'required|image',
            'jam_buka' => 'required|max:255',
            'jam_tutup' => 'required|max:255',
            'daerah_dagang' => 'required|max:255',
        ];
    }
}
