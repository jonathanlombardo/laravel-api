<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TypeDeleteRequest extends FormRequest
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
    return [
      'action_on_project' => 'required|exists:types,id',
    ];
  }

  public function messages()
  {
    $prefix = 'Delete type failed.';
    return [
      'action_on_project.required' => "$prefix Choosing an option for projects is required.",
      'action_on_project.exists' => "$prefix Please choose a valid option for action on projects.",
    ];
  }
}
