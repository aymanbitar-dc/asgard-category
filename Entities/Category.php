<?php

namespace Modules\Category\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Translatable;

    protected $table = 'category__categories';
    public $translatedAttributes = ['slug', 'name'];
    protected $fillable = ['slug', 'name'];
}
