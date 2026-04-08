<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Enums\PostStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StorePostRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'string', Rule::enum(PostStatus::class)],
            'published_at' => ['nullable', 'date'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:5120'],
        ];
    }
}
