<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Services\Dashboard\CategoryService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\CategoryRequest;

class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return $this->categoryService->index();
    }

    public function create()
    {
        return $this->categoryService->create();
    }

    public function store(CategoryRequest $request)
    {
        return $this->categoryService->store($request);
    }

    public function show($id)
    {
        return $this->categoryService->show($id);
    }

    public function edit($id)
    {
        return $this->categoryService->edit($id);
    }

    public function update(CategoryRequest $request,$id)
    {
        return $this->categoryService->update($request,$id);
    }

    public function destroy($id)
    {
        return $this->categoryService->delete($id);
    }
}
