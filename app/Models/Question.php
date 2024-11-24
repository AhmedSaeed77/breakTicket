<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';
    protected $guarded = [];

    public function getQuestionAttribute()
    {
        if(app()->getLocale()=='en')
        {
            return $this->question_en;
        }
        else
        {
            return $this->question_ar;
        } 
    }

    public function getAnswerAttribute()
    {
        if(app()->getLocale()=='en')
        {
            return $this->answer_en;
        }
        else
        {
            return $this->answer_ar;
        } 
    }
}
