<?php

namespace App\Http\Requests\Config;

use App\Rules\UniqueFeelingList;
use Illuminate\Foundation\Http\FormRequest;

class FeelingListRequest extends FormRequest
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
          $feelingListId = $this->route('feeling_list');
          return [
              'name'      => ['required', 'max:30', new UniqueFeelingList($feelingListId)],
              'emoji'     => [$feelingListId ? 'nullable' : 'required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
              'is_active' => ['nullable', 'boolean']
          ];
      }


}
