<?php

namespace Modules\Category\Sidebar;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\User\Contracts\Authentication;

class SidebarExtender implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Menu $menu
     *
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('category::categories.title.categories'), function (Item $item) {
                $item->icon('fa fa-tag');
                $item->weight(0);
                $item->route('admin.category.category.index');
                $item->authorize(
                    $this->auth->hasAccess('category.categories.index')
                );
            });
        });

        return $menu;
    }
}
