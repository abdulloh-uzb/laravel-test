<?php

namespace App\Commands;
use App\Models\Country;

class CheckQuestionsCommand implements Command
{

    public function __construct(protected $answers){}

    public function execute()
    {
        $rightAnswers = 0;
        foreach($this->answers as $answer){
            if(Country::where("capital", $answer['question'])->where("name", $answer['selected'])->exists()){
                $rightAnswers++; 
            }
        }
        return $rightAnswers;
    }

}