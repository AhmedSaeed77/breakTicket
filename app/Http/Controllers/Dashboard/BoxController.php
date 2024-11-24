<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\BoxRequest;
use App\Http\Services\Dashboard\BoxService;

class BoxController extends Controller
{
    private BoxService $boxService;

    public function __construct(BoxService $boxService)
    {
        $this->boxService = $boxService;
    }

    public function index()
    {
        return $this->boxService->index();
    }

    public function create($id)
    {
        return $this->boxService->create($id);
    }

    public function store(BoxRequest $request,$id)
    {
        return $this->boxService->store($request,$id);
    }

    public function show($id)
    {
        return $this->boxService->show($id);
    }

    public function edit($event_id,$id)
    {
        return $this->boxService->edit($event_id,$id);
    }

    public function update(BoxRequest $request,$event_id,$id)
    {
        return $this->boxService->update($request,$event_id,$id);
    }

    public function destroy($event_id,$id)
    {
        return $this->boxService->delete($event_id,$id);
    }
}
