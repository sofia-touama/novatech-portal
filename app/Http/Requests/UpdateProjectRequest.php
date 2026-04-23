<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Authorise only the owner to update the project.
     */
    public function authorize()
    {
        // The route model binding gives us the Project instance
        $project = $this->route('project');

        return $project && $project->uid === auth()->id();
    }

    /**
     * Validation rules for updating a project.
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
