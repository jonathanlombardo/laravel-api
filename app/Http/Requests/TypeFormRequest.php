<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TypeFormRequest extends FormRequest
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
    $type = $this->route('type');
    if ($type)
      $id = $type->id;
    // dd($project);
    return [
      'label' => ['required', $type ? Rule::unique('types', 'label')->ignore($id) : Rule::unique('types', 'label'), 'max:50'],
      'color' => ['required', $type ? Rule::unique('types', 'color')->ignore($id) : Rule::unique('types', 'color'), 'min:7', 'max:7'],
      'description' => 'nullable|string',
    ];
  }
}
