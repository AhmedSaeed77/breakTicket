<?php

namespace App\Http\Controllers\api;

use App\Http\Services\api\QuestionService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    private QuestionService $questionService;

    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    public function getCommonQuestions()
    {
        return $this->questionService->getCommonQuestions();
    }
}
