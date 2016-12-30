<?php

namespace Modules\Category\Http\Controllers\Admin;

use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Category\Entities\Category;
use Modules\Category\Http\Requests\CreateCategoryRequest;
use Modules\Category\Http\Requests\UpdateCategoryRequest;
use Modules\Category\Repositories\CategoryManager;
use Modules\Category\Repositories\CategoryRepository;
use Illuminate\Http\Response;

class CategoryController extends AdminBaseController
{
    /**
     * @var CategoryRepository
     */
    private $category;

    /**
     * @var CategoryManager
     */
    private $categoryManager;

    public function __construct(CategoryRepository $category, CategoryManager $categoryManager)
    {
        parent::__construct();

        $this->category = $category;
        $this->categoryManager = $categoryManager;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories = $this->category->all();

        return view('category::admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $namespaces = $this->formatNamespaces($this->categoryManager->getNamespaces());

        return view('category::admin.categories.create', compact('namespaces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCategoryRequest $request
     * @return Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $this->category->create($request->all());

        return redirect()->route('admin.category.category.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('category::categories.title.categories')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Category $category
     * @return Response
     */
    public function edit(Category $category)
    {
        return view('category::admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Category $category
     * @param  UpdateCategoryRequest $request
     * @return Response
     */
    public function update(Category $category, UpdateCategoryRequest $request)
    {
        $this->category->update($category, $request->all());

        return redirect()->route('admin.category.category.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('category::categories.title.categories')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Category $category
     * @return Response
     */
    public function destroy(Category $category)
    {
        $this->category->destroy($category);

        return redirect()->route('admin.category.category.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('category::categories.title.categories')]));
    }

    private function formatNamespaces(array $namespaces)
    {
        $new = [];
        foreach ($namespaces as $namespace) {
            $new[$namespace] = $namespace;
        }

        return $new;
    }
}
