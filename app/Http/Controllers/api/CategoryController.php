<?php

namespace App\Http\Controllers\api;

use App\Http\Services\api\CategoryService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function getAllCategories()
    {
        return $this->categoryService->getAllCategories();
    }
}
