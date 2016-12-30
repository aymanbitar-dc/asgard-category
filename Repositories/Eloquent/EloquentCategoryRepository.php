<?php

namespace Modules\Category\Repositories\Eloquent;

use Modules\Category\Repositories\CategoryRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepository
{
    /**
     * Get all the categories in the given namespace
     * @param string $namespace
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allForNamespace($namespace)
    {
        return $this->model->with('translations')->where('namespace', $namespace)->get();
    }
}
