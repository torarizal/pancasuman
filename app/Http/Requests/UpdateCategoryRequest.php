<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Pastikan hanya user yang login yang bisa mengakses
    }

    public function rules(): array
{
    return [
        'name' => 'required|string|max:255',
        'slug' => 'nullable|string|max:255|unique:categories,slug,' . $this->route('category')->id,
        'description' => 'nullable|string',
        'status' => 'required|in:active,inactive',
    ];
}
}