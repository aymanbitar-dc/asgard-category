<?php

namespace Modules\Category\Blade;

use Modules\Category\Contracts\CategorizableInterface;
use Modules\Category\Repositories\CategoryRepository;

class CategoryWidget
{
    /**
     * @var CategoryRepository
     */
    private $category;
    /**
     * @var string
     */
    private $namespace;
    /**
     * @var CategorizableInterface|null
     */
    private $entity;
    /**
     * @var string|null
     */
    private $view;
    /**
     * @var string|null
     */
    private $name;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    /**
     * @param $arguments
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($arguments)
    {
        $this->extractArguments($arguments);

        $view = $this->view ?: 'category::admin.fields.categories';

        $name = $this->name ?: 'Categories';

        $availableCategories = $this->category->allForNamespace($this->namespace);

        $categories = $this->getCategories();

        return view($view, compact('availableCategories', 'categories', 'name'));
    }

    /**
     * Extract the possible arguments as class properties
     * @param array $arguments
     */
    private function extractArguments(array $arguments)
    {
        $this->namespace = array_get($arguments, 0);
        $this->entity = array_get($arguments, 1);
        $this->view = array_get($arguments, 2);
        $this->name = array_get($arguments, 3);
    }

    /**
     * Get the available categories, if an entity is available from that
     * @return array
     */
    private function getCategories()
    {
        if ($this->entity === null) {
            return request()->old('categories', []);
        }

        return request()->old('categories', $this->entity->categories->pluck('slug')->toArray());
    }
}
