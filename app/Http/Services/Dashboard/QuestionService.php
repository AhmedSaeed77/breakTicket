<?php

namespace App\Http\Services\Dashboard;
use App\Http\Requests\Dashboard\QuestionRequest;
use App\Traits\GeneralTrait;
use App\Repository\QuestionRepositoryInterface;

class QuestionService
{
    use GeneralTrait;
    protected QuestionRepositoryInterface $questionRepository;
    public function __construct(QuestionRepositoryInterface $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }
    public function index()
    {
        $questions = $this->questionRepository->paginate();
        return view('dashboard.question.index' , ['questions' => $questions]);
    }

    public function create()
    {
        return view('dashboard.question.create');
    }

    public function store(QuestionRequest $request)
    {
        $data = array_merge($request->input());
        $this->questionRepository->create($data);
        return redirect('commonquestion')->with(["success"=>__('dashboard.recored created successfully.')]);
    }

    public function show($id)
    {
        $question = $this->questionRepository->getById($id);
        return view('dashboard.question.show' , ['question' => $question]);
    }

    public function edit($id)
    {
        $question = $this->questionRepository->getById($id);
        return view('dashboard.question.edit' , ['question' => $question]);
    }

    public function update(QuestionRequest $request,$id)
    {
        $question = $this->questionRepository->getById($id);
        $data = array_merge($request->input());
        $this->questionRepository->update($question->id,$data);
        return redirect('commonquestion')->with(["success"=>__('dashboard.recored updated successfully.')]);
    }

    public function delete($id)
    {
        $this->questionRepository->delete($id);
        return redirect('commonquestion')->with(["success"=>__('dashboard.recored deleted successfully.')]);
    }
}
