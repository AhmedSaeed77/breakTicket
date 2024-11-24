<?php

namespace App\Http\Services\api;
use App\Repository\QuestionRepositoryInterface;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Resources\api\QuestionResource;

class QuestionService
{
    use GeneralTrait;
    protected QuestionRepositoryInterface $questionRepository;
    public function __construct(QuestionRepositoryInterface $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }
    public function getCommonQuestions()
    {
        $questions = $this->questionRepository->getAll();
        $questions_data = QuestionResource::collection($questions);
        return $this->returnData('data',$questions_data);
    }
}
