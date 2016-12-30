<?php

namespace Modules\Category\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface CategoryRepository extends BaseRepository
{
    /**
     * Get all the categories in the given namespace
     * @param string $namespace
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allForNamespace($namespace);
}
