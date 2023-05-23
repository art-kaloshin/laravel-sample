<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $text
 * @property array $section
 */
class NewsRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'nullable|int|exists:news,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:512',
            'text' => 'required|string',
            'section' => 'array',
            'section.*.id' => 'int'
        ];
    }
}
