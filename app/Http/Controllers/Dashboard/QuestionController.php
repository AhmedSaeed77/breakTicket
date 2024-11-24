<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\QuestionRequest;
use App\Http\Services\Dashboard\QuestionService;

class QuestionController extends Controller
{
    private QuestionService $questionService;

    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    public function index()
    {
        return $this->questionService->index();
    }

    public function create()
    {
        return $this->questionService->create();
    }

    public function store(QuestionRequest $request)
    {
        return $this->questionService->store($request);
    }

    public function show($id)
    {
        return $this->questionService->show($id);
    }

    public function edit($id)
    {
        return $this->questionService->edit($id);
    }

    public function update(QuestionRequest $request,$id)
    {
        return $this->questionService->update($request,$id);
    }

    public function destroy($id)
    {
        return $this->questionService->delete($id);
    }
}
