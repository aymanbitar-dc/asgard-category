<?php

namespace Modules\Category\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateCategoryRequest extends BaseFormRequest
{
    protected $translationsAttributesKey = 'category::categories.validation.attributes';

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

    public function translationMessages()
    {
        return [
            'name.required' => trans($this->translationsAttributesKey . '.name'),
            'slug.required' => trans($this->translationsAttributesKey . '.slug'),
        ];
    }
}
