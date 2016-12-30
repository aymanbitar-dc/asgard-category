<?php
/**
 * Created by PhpStorm.
 * User: dc-ayman
 * Date: 12/29/16
 * Time: 3:56 PM
 */

namespace Modules\Category\Repositories;

use Modules\Category\Contracts\CategorizableInterface;

interface CategoryManager
{
    /**
     * Returns all the registered namespaces.
     * @return array
     */
    public function getNamespaces();

    /**
     * Registers an entity namespace.
     * @param CategorizableInterface $entity
     * @return void
     */
    public function registerNamespace(CategorizableInterface $entity);
}