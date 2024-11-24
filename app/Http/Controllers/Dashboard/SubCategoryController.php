<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\SubcategoryRequest;
use App\Http\Services\Dashboard\SubcategoryService;

class SubCategoryController extends Controller
{
    private SubcategoryService $subcategoryService;

    public function __construct(SubcategoryService $subcategoryService)
    {
        $this->subcategoryService = $subcategoryService;
    }

    public function index()
    {
        return $this->subcategoryService->index();
    }

    public function create($id)
    {
        return $this->subcategoryService->create($id);
    }

    public function store(Request $request,$id)
    {
        return $this->subcategoryService->store($request,$id);
    }

    public function show($id)
    {
        return $this->subcategoryService->show($id);
    }

    public function edit($event_id,$id)
    {
        return $this->subcategoryService->edit($event_id,$id);
    }

    public function update(SubcategoryRequest $request,$event_id,$id)
    {
        return $this->subcategoryService->update($request,$event_id,$id);
    }

    public function destroy($event_id,$id)
    {
        return $this->subcategoryService->delete($event_id,$id);
    }
}
