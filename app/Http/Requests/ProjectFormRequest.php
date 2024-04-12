<?php

namespace App\Http\Requests;

use App\Models\Type;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectFormRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules()
  {
    $project = $this->route('project');
    if ($project)
      $id = $project->id;
    // dd($project);
    return [
      'title' => ['required', $project ? Rule::unique('projects')->ignore($id) : Rule::unique('projects'), 'max:100'],
      // 'author' => [$project ? 'required' : 'nullable', 'string', 'max:50'],
      'type_id' => 'required|exists:types,id',
      'description' => 'nullable|string',
      'git_hub' => ['nullable', 'url', $project ? Rule::unique('projects')->ignore($id) : Rule::unique('projects')],
      'image' => 'nullable|image',
      'techs' => 'nullable|exists:technologies,id'
    ];
  }
}
