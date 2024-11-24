<?php

namespace App\Http\Services\Dashboard;
use App\Http\Requests\Dashboard\SubcategoryRequest;
use App\Repository\subcategoryRepositoryInterface;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class SubcategoryService
{
    use GeneralTrait;
    protected subcategoryRepositoryInterface $subcategoryRepository;
    public function __construct(subcategoryRepositoryInterface $subcategoryRepository)
    {
        $this->subcategoryRepository = $subcategoryRepository;
    }

    public function index($id)
    {
        $subcategory = $this->subcategoryRepository->get('event_id',$id);
        return view('dashboard.subcategory.index' , ['subcategory' => $subcategory]);
    }

    public function create($id)
    {
        return view('dashboard.subcategory.create',['id'=> $id]);
    }

    public function store(Request $request,$id)
    {
        if($request->kt_docs_repeater_basic)
        {
            foreach($request->kt_docs_repeater_basic as $subcategory)
            {
                $data = array_merge([
                                        'name_ar' => $subcategory['name_ar'] ,
                                        'name_en' => $subcategory['name_en'] ,
                                        'event_id'=> $id
                                    ]);
                $this->subcategoryRepository->create($data);
            }
        }
        return redirect()->route('event.show',$id)->with(["success"=>__('dashboard.recored created successfully.')]);
    }

    public function show($id)
    {
        $subcategory = $this->subcategoryRepository->getById($id);
        return view('dashboard.event.show' , ['subcategory' => $subcategory]);
    }

    public function edit($event_id,$id)
    {
        $subcategory = $this->subcategoryRepository->getById($id);
        return view('dashboard.subcategory.edit' , ['subcategory' => $subcategory , 'event_id' => $event_id]);
    }

    public function update(SubcategoryRequest $request,$event_id,$id)
    {
        $subcategory = $this->subcategoryRepository->getById($id);
        $data = array_merge($request->input());
        $this->subcategoryRepository->update($subcategory->id,$data);
        return redirect()->route('event.show',$event_id)->with(["success"=>__('dashboard.recored updated successfully.')]);
    }

    public function delete($event_id,$id)
    {
        $this->subcategoryRepository->delete($id);
        return redirect()->route('event.show',$event_id)->with(["success"=>__('dashboard.recored deleted successfully.')]);
    }
}
