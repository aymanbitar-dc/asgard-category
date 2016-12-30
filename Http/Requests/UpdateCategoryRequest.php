<?php

namespace Modules\Category\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateCategoryRequest extends BaseFormRequest
{
    public function translationRules()
    {
        return [
            'slug' => 'required',
            'name' => 'required',
        ];
    }

    public function rules()
    {
        return [

        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [];
    }
}
