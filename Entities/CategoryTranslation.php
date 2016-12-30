<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['slug', 'name'];
    protected $table = 'category__category_translations';
}
