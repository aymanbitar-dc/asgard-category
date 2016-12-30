<?php

namespace Modules\Category\Repositories\Cache;

use Modules\Category\Repositories\CategoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCategoryDecorator extends BaseCacheDecorator implements CategoryRepository
{
    public function __construct(CategoryRepository $category)
    {
        parent::__construct();
        $this->entityName = 'category.categories';
        $this->repository = $category;
    }

    /**
     * Get all the categories in the given namespace
     * @param string $namespace
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allForNamespace($namespace)
    {
        return $this->cache
            ->categories([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.allForNamespace.{$namespace}", $this->cacheTime,
                function () use ($namespace) {
                    return $this->repository->allForNamespace($namespace);
                }
            );
    }
}
