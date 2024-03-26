<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JajananRequest extends FormRequest
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
            'nama' => 'required|max:255',
            'deskripsi' => 'required|max:255',
            'harga' => 'required|numeric',
            'image' => 'required|image',
            'kategori' => 'required|max:255',
        ];
    }
}
