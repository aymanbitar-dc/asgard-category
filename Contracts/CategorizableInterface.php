<?php

namespace Modules\Category\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface CategorizableInterface
{
    /**
     * The Eloquent category entity name.
     * @var string
     */
    public static function getEntityNamespace();

    /**
     * Returns the Eloquent categories entity name.
     * @return string
     */
    public static function getCategoriesModel();

    /**
     * Sets the Eloquent categories entity name.
     * @param string $model
     * @return void
     */
    public static function setCategoriesModel($model);

    /**
     * Get all the entities with the given category(s)
     * Optionally specify the column on which
     * to perform the search operation.
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|array $categories
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereCategory(Builder $query, $categories, $type = 'slug');

    /**
     * Get all the entities with one of the given category(s)
     * Optionally specify the column on which
     * to perform the search operation.
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|array $categories
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithCategory(Builder $query, $categories, $type = 'slug');

    /**
     * Define the eloquent morphMany relationship
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function categories();

    /**
     * Returns all the categories under the current entity namespace.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function allCategories();

    /**
     * Creates a new model instance.
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function createCategoriesModel();

    /**
     * Syncs the given categories.
     * @param  string|array $categories
     * @param  string $categories
     * @return bool
     */
    public function setCategories($categories, $type = 'name');

    /**
     * Detaches multiple categories from the entity or if no categories are
     * passed, removes all the attached categories from the entity.
     * @param  string|array|null $categories
     * @return bool
     */
    public function uncategorize($categories = null);

    /**
     * Detaches the given category from the entity.
     * @param  string  $name
     * @return void
     */
    public function removeCategory($name);

    /**
     * Attaches multiple categories to the entity.
     * @param  string|array  $categories
     * @return bool
     */
    public function category($categories);

    /**
     * Attaches the given category to the entity.
     * @param  string $name
     * @return void
     */
    public function addCategory($name);
}