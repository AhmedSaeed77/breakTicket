<?php

namespace App\Http\Services\Dashboard;
use App\Http\Requests\Dashboard\CategoryRequest;
use App\Repository\CategoryRepositoryInterface;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CategoryService
{
    use GeneralTrait;
    protected CategoryRepositoryInterface $categoryRepository;
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function index()
    {
        $categories = $this->categoryRepository->paginate();
        return view('dashboard.category.index' , ['categories' => $categories]);
    }

    public function create()
    {
        return view('dashboard.category.create');
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->input();
        if($request->hasFile('image'))
        {
            $image = $this->handle('image', 'categories');
            $data = array_merge($request->input(),["image"=>$image]);
        }
        $this->categoryRepository->create($data);
        return redirect('category')->with(["success"=>__('dashboard.recored created successfully.')]);
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $category = $this->categoryRepository->getById($id);
        return view('dashboard.category.edit' , ['category' => $category]);
    }

    public function update(CategoryRequest $request,$id)
    {
        $category = $this->categoryRepository->getById($id);
        $data = $request->input();
        if($request->hasFile('image'))
        {
            $image = $this->handle('image', 'categories');
            $data = array_merge($request->input(),["image"=>$image]);
            $this->deleteImage($category->image);
        }
        $this->categoryRepository->update($category->id,$data);
        return redirect('category')->with(["success"=>__('dashboard.recored updated successfully.')]);
    }

    public function delete($id)
    {
        $this->categoryRepository->delete($id);
        return redirect('category')->with(["success"=>__('dashboard.recored deleted successfully.')]);
    }
}
