<div class='form-group{{ $errors->has('categories') ? ' has-error' : '' }}'>
    {!! Form::label('categories', $name) !!}
    <select name="categories[]" id="categories" class="input-tags" multiple>
        <?php foreach ($availableCategories as $category): ?>
        <option value="{{ $category->slug }}" {{ in_array($category->slug, $category) ? ' selected' : null }}>{{ $category->name }}</option>
        <?php endforeach; ?>
    </select>
    {!! $errors->first('categories', '<span class="help-block">:message</span>') !!}
</div>
<script>
    $( document ).ready(function() {
        $('.input-tags').selectize({
            plugins: ['remove_button'],
            delimiter: ',',
            persist: false,
            create: function(input) {
                return {
                    value: input,
                    text: input
                }
            }
        });
    });
</script>
