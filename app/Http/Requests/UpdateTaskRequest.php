<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled in controller
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'status'      => ['required', 'in:' . Task::STATUS_PENDING . ',' . Task::STATUS_DONE],
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'A task title is required.',
            'title.max'      => 'Task title cannot exceed 255 characters.',
            'status.in'      => 'Status must be either pending or done.',
        ];
    }
}
