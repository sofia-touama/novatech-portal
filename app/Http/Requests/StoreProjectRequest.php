<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Authorise all authenticated users to create projects.
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Validation rules for creating a project.
     */
    public function rules()
    {
        return [
            'title'             => 'required|max:255',
            'short_description' => 'required',
            'start_date'        => 'required|date',
            'end_date'          => 'nullable|date|after_or_equal:start_date',
            'phase'             => 'required|in:design,development,testing,deployment,complete',
        ];
    }
}
