<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateItemRequest extends FormRequest
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
            'item_name' => 'required|string|max:255',
            'item_description' => 'required|string|max:500',
            'item_price' => 'required|numeric|min:0',
            'is_active' => 'required|in:0,1',
        ];
    }
    public function messages(): array
    {
        return [
            'item_name.required' => 'إسم العنصر مطلوب.',
            'item_description.required' => 'وصف العنصر مطلوب.',
            'item_price.required' => 'سعر العنصر مطلوب.',
            'item_price.numeric' => 'سعر العنصر يجب ان يكون رقم.',
            'is_active.required' => 'حالة العنصر مطلوبة.',
        ];
    }
}
