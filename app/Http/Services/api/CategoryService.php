<?php

namespace App\Http\Services\api;

use App\Repository\CategoryRepositoryInterface;
use App\Traits\GeneralTrait;
use App\Http\Resources\api\CategoryResource;

class CategoryService
{
    use GeneralTrait;

    protected CategoryRepositoryInterface $categoryRepository;
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function getAllCategories()
    {
        $categories = $this->categoryRepository->getAll();
        $category_data = CategoryResource::collection($categories);
        return $this->returnData('data',$category_data);
    }
}
