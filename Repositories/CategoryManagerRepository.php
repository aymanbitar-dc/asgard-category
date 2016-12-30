<?php
/**
 * Created by PhpStorm.
 * User: dc-ayman
 * Date: 12/29/16
 * Time: 4:02 PM
 */

namespace Modules\Category\Repositories;


use Modules\Category\Contracts\CategorizableInterface;

class CategoryManagerRepository implements CategoryManager
{
    /**
     * Array of registered namespaces.
     * @var array
     */
    private $namespaces = [];

    /**
     * Returns all the registered namespaces.
     * @return array
     */
    public function getNamespaces()
    {
        return $this->namespaces;
    }

    /**
     * Registers an entity namespace.
     * @param CategorizableInterface $entity
     * @return void
     */
    public function registerNamespace(CategorizableInterface $entity)
    {
        $this->namespaces[] = $entity->getEntityNamespace();
    }
}