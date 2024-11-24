<?php

namespace App\Http\Services\Dashboard;
use App\Http\Requests\Dashboard\BoxRequest;
use App\Traits\GeneralTrait;
use App\Models\Box;

class BoxService
{
    use GeneralTrait;

    public function index($id)
    {
        $boxs = Box::where('event_id',$id)->orderBy('created_at', 'desc')->get();
        return view('dashboard.box.index' , ['boxes' => $boxs]);
    }

    public function create($id)
    {
        return view('dashboard.box.create',['id'=> $id]);
    }

    public function store(BoxRequest $request,$id)
    {
        $data = array_merge($request->input(),['event_id'=> $id]);
        $box = Box::create($data);
        return redirect()->route('event.show',$id)->with(["success"=>__('dashboard.recored created successfully.')]);
    }

    public function show($id)
    {
        $box = Box::find($id);
        return view('dashboard.event.show' , ['box' => $box]);
    }

    public function edit($event_id,$id)
    {
        $box = Box::find($id);
        return view('dashboard.box.edit' , ['box' => $box , 'event_id' => $event_id]);
    }

    public function update(BoxRequest $request,$event_id,$id)
    {
        $box = Box::find($id);
        $data = array_merge($request->input());
        $box->update($data);
        return redirect()->route('event.show',$event_id)->with(["success"=>__('dashboard.recored updated successfully.')]);
    }

    public function delete($event_id,$id)
    {
        $box = Box::find($id);
        $box->delete();
        return redirect()->route('event.show',$event_id)->with(["success"=>__('dashboard.recored deleted successfully.')]);
    }
}
