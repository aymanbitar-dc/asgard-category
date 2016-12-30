<div class="box-body">
    <div class="box-body">
        {!! Form::i18nInput('name', trans('category::categories.name'), $errors, $lang, $category, ['data-slug' => 'source']) !!}
        {!! Form::i18nInput('slug', trans('category::categories.slug'), $errors, $lang, $category, ['data-slug' => 'target']) !!}
    </div>
</div>
