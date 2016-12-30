<?php

namespace Modules\Category\Traits;

use Illuminate\Database\Eloquent\Builder;
use Modules\Category\Entities\Category;

trait CategorizableTrait
{
    /**
     * {@inheritdoc}
     */
    protected static $categoriesModel = Category::class;

    /**
     * {@inheritdoc}
     */
    public static function getCategoriesModel()
    {
        return static::$categoriesModel;
    }

    /**
     * {@inheritdoc}
     */
    public static function setCategoriesModel($model)
    {
        static::$categoriesModel = $model;
    }

    /**
     * {@inheritdoc}
     */
    public function scopeWhereCategory(Builder $query, $categories, $type = 'slug')
    {
        if (is_string($categories) === true) {
            $categories = [$categories];
        }
        $query->with('translations');

        foreach ($categories as $category) {
            $query->whereHas('categories', function (Builder $query) use ($type, $category) {
                $query->whereHas('translations', function (Builder $query) use ($type, $category) {
                    $query->where($type, $category);
                });
            });
        }

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public function scopeWithCategory(Builder $query, $categories, $type = 'slug')
    {
        if (is_string($categories) === true) {
            $categories = [$categories];
        }
        $query->with('translations');

        return $query->whereHas('categories', function (Builder $query) use ($type, $categories) {
            $query->whereHas('translations', function (Builder $query) use ($type, $categories) {
                $query->whereIn($type, $categories);
            });
        });
    }

    /**
     * {@inheritdoc}
     */
    public function categories()
    {
        return $this->morphToMany(static::$categoriesModel, 'taggable', 'category__tagged', 'target_id', 'category_id');
    }

    /**
     * {@inheritdoc}
     */
    public static function createCategoriesModel()
    {
        return new static::$categoriesModel;
    }

    /**
     * {@inheritdoc}
     */
    public static function allCategories()
    {
        $instance = new static;

        return $instance->createCategoriesModel()->with('translations')->whereNamespace($instance->getCategoryEntityClassName());
    }

    /**
     * {@inheritdoc}
     */
    public function setCategories($categories, $type = 'slug')
    {
        // Get the current entity categories
        $entityCategories = $this->categories->pluck($type)->all();

        // Prepare the categories to be added and removed
        $categoriesToAdd = array_diff($categories, $entityCategories);
        $categoriesToDel = array_diff($entityCategories, $categories);

        // Detach the categories
        if (count($categoriesToDel) > 0) {
            $this->uncategorize($categoriesToDel);
        }

        // Attach the categories
        if (count($categoriesToAdd) > 0) {
            $this->category($categoriesToAdd);
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function category($categories)
    {
        foreach ($categories as $category) {
            $this->addCategory($category);
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function addCategory($name)
    {
        $cateogry = $this->createCategoriesModel()->where('namespace', $this->getCategoryEntityClassName())
            ->with('translations')
            ->whereHas('translations', function (Builder $q) use ($name) {
            $q->where('slug', $this->generateCategorySlug($name));
        })->first();

        if ($cateogry === null) {
            $cateogry = new Category([
                'namespace' => $this->getCategoryEntityClassName(),
                app()->getLocale() => [
                    'slug' => $this->generateCategorySlug($name),
                    'name' => $name,
                ],
            ]);
        }
        if ($cateogry->exists === false) {
            $cateogry->save();
        }

        if ($this->categories->contains($cateogry->id) === false) {
            $this->categories()->attach($cateogry);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function uncategorize($categories = null)
    {
        $categories = $categories ?: $this->categories->pluck('name')->all();

        foreach ($categories as $category) {
            $this->removeCategory($category);
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function removeCategory($name)
    {
        $category = $this->createCategoriesModel()
            ->where('namespace', $this->getCategoryEntityClassName())
            ->with('translations')
            ->whereHas('translations', function (Builder $q) use ($name) {
                $q->orWhere('name', $this->generateCategorySlug($name));
                $q->orWhere('slug', $this->generateCategorySlug($name));
            })->first();

        if ($category) {
            $this->categories()->detach($category);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getCategoryEntityClassName()
    {
        if (isset(static::$entityNamespace)) {
            return static::$entityNamespace;
        }

        return $this->categories()->getMorphClass();
    }

    /**
     * {@inheritdoc}
     */
    protected function generateCategorySlug($name)
    {
        return str_slug($name);
    }
}
