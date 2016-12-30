<?php

namespace Modules\Category\Blade\Facades;

use Illuminate\Support\Facades\Facade;

class CategoryWidget extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'category.widget.directive';
    }
}
