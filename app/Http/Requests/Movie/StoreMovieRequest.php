<?php

namespace App\Http\Requests\Movie;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'required|string|min:3',
            'release_date' => 'required|date',
            'cover' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'trailer' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime',
            'genres' => 'required|array',
        ];
    }
}
