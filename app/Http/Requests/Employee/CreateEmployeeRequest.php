<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'email' => 'required|email|string|unique:employees',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:1048',
            'gender' => 'required|in:male,female',
            'team_id' => 'required|integer|exists:teams,id',
            'company_id' => 'required|integer|exists:companies,id'
        ];
    }
}
