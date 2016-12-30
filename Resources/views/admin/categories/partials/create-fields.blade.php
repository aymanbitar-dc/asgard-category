<div class="box-body">
    {!! Form::i18nInput('name', trans('category::categories.name'), $errors, $lang, null, ['data-slug' => 'source']) !!}
    {!! Form::i18nInput('slug', trans('category::categories.slug'), $errors, $lang, null, ['data-slug' => 'target']) !!}
</div>
