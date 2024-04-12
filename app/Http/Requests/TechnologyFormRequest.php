<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TechnologyFormRequest extends FormRequest
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

    $technology = $this->route('technology');
    if ($technology)
      $id = $technology->id;
    return [
      'label' => ['required', $technology ? Rule::unique('technologies', 'label')->ignore($id) : Rule::unique('technologies', 'label'), 'max:50'],
      'color' => ['required', $technology ? Rule::unique('technologies', 'color')->ignore($id) : Rule::unique('technologies', 'color'), 'min:7', 'max:7'],
      'description' => 'nullable|string',
    ];

  }
}
