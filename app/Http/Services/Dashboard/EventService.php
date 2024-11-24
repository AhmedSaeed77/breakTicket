<?php

namespace App\Http\Services\Dashboard;
use App\Http\Requests\Dashboard\EventRequest;
use App\Traits\GeneralTrait;
use App\Repository\EventRepositoryInterface;
use App\Repository\CategoryRepositoryInterface;

class EventService
{
    use GeneralTrait;
    protected CategoryRepositoryInterface $categoryRepository;
    protected EventRepositoryInterface $eventRepository;
    public function __construct(CategoryRepositoryInterface $categoryRepository , EventRepositoryInterface $eventRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->eventRepository = $eventRepository;
    }

    public function index()
    {
        $events = $this->eventRepository->getAllEvents();
        return view('dashboard.event.index' , ['events' => $events]);
    }

    public function create()
    {
        $categories = $this->categoryRepository->getAll();
        return view('dashboard.event.create' , ['categories' => $categories]);
    }

    public function store(EventRequest $request)
    {
        if($request->hasFile('image'))
        {
            $image = $this->handle('image', 'events');
        }
        if($request->hasFile('coverimage'))
        {
            $coverimage = $this->handle('coverimage', 'events');
        }
        if($request->hasFile('blogimage'))
        {
            $blogimage = $this->handle('blogimage', 'events');
        }
        $is_popular = $request->is_popular ? 1 : 0;
        $is_active = $request->is_active ? 1 : 0;
        $slug_ar = '';
        $slug_en = '';
        $data = array_merge($request->input(),[
                                                    "image" => $image,
                                                    "coverimage" => $coverimage,
                                                    "blogimage" => $blogimage,
                                                    "is_popular" => $is_popular,
                                                    "is_active" => $is_active,
                                                    "slug_ar" => $slug_ar,
                                                    "slug_en" => $slug_en
                                                ]);
        $event = $this->eventRepository->create($data);
        $delimiter = '-';
        $slug_en = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $event->name_en))))), $delimiter));
        $arr = [" ","/","[","]","(",")","#","$"];
        $slug_ar =str_replace($arr, "-", $event->name_ar);
        $this->eventRepository->update($event->id,['slug_ar' => $slug_ar , 'slug_en' => $slug_en]);
        return redirect('event')->with(["success"=>__('dashboard.recored created successfully.')]);
    }

    public function show($id)
    {
        $event = $this->eventRepository->getById($id);
        return view('dashboard.event.show' , ['event' => $event]);
    }

    public function edit($id)
    {
        $event = $this->eventRepository->getById($id);
        $categories = $this->categoryRepository->getAll();
        return view('dashboard.event.edit' , ['event' => $event , 'categories' => $categories]);
    }

    public function update(EventRequest $request,$id)
    {
        $event = $this->eventRepository->getById($id);
        $data = $request->input();
        if($request->hasFile('image'))
        {
            $image = $this->handle('image', 'events');
            $data = array_merge($data,["image"=>$image]);
            $this->deleteImage($event->image);
        }
        if($request->hasFile('coverimage'))
        {
            $coverimage = $this->handle('coverimage', 'events');
            $data = array_merge($data,["coverimage"=>$coverimage]);
            $this->deleteImage($event->coverimage);
        }
        if($request->hasFile('blogimage'))
        {
            $blogimage = $this->handle('blogimage', 'events');
            $data = array_merge($data,["blogimage"=>$blogimage]);
            $this->deleteImage($event->blogimage);
        }
        $is_popular = $request->is_popular ? 1 : 0;
        $is_active = $request->is_active ? 1 : 0;
        $data = array_merge($data,["is_popular"=>$is_popular,"is_active" => $is_active]);
        $this->eventRepository->update($id,$data);
        // $delimiter = '-';
        // $event->slug_en = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $request->name_en))))), $delimiter));
        $arr = [" ","/","[","]","(",")","#","$"];
        $slug_ar = str_replace($arr, "-", $request->name_ar);
        $slug_en = str_replace($arr, "-", $request->name_en);
        $this->eventRepository->update($event->id,['slug_ar' => $slug_ar , 'slug_en' => $slug_en]);
        return redirect('event')->with(["success"=>__('dashboard.recored updated successfully.')]);
    }

    public function delete($id)
    {
        $this->eventRepository->delete($id);
        return redirect('event')->with(["success"=>__('dashboard.recored deleted successfully.')]);
    }

    public function eventstatus($id)
    {
        $event = $this->eventRepository->getById($id);
        $this->eventRepository->update($event->id,['is_active' => $event->is_active == 1 ? 0 : 1]);
        return redirect()->back()->with(["success"=>__('dashboard.recored deleted successfully.')]);
    }

    public function active($id)
    {
        $event = $this->eventRepository->getById($id);
        $this->eventRepository->update($event->id,['is_active' => $event->is_active == 0 ? 1 : 0]);
        return redirect()->back()->with(["success"=>__('dashboard.recored deleted successfully.')]);
    }
}
