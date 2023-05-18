<?php

namespace VuongCMS\Cms\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
   * Prepare the data for validation.
   *
   * @return void
   */
  protected function prepareForValidation()
  {
    if ($this->isMethod('get')) {
      $this->merge([
        'email' => 'test@gmail.com',
        'password' => '!23456Abc'
      ]);
    }
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'email' => ['required', 'email'],
      'password' => ['required', 'min:8', 'max:64'],
    ];
  }
}
