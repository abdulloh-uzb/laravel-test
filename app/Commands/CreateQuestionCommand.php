<?php

namespace App\Commands;


class CreateQuestionCommand implements Command{

    public function __construct(protected $data){}

    public function execute()
    {
        $countries = [];
        foreach ($this->data as $country) {
            $countries[] = $country->getAttributes();
        }
        $randomQuestion = [];
        
        $questions = [
            "{poytaxt} qaysi davlatni poytaxti?",
            "{davlat} ning poytaxti qaysi?",
            "{davlat} ning aholisi qancha?",
            "{davlat} qaysi qit'a da joylashgan?"
        ];


        $randQuestion = "";
        $result = [];
        for ($i=0; $i < 5; $i++) { 
            $randIdx = 0;
            $randQuestion = $questions[$randIdx];

            if($randIdx === 0){
                
                // find random country to make question
                $randIdxForQuestion = array_rand($countries); 
                $randomCountry =  $countries[$randIdxForQuestion];
                $randomCapital = $randomCountry['capital'];
                $rightAnswer = $randomCountry['name'];
                
                // get variants
                $variants = array_filter($countries, fn($item) => $item !== $randomCountry);
                $variants = array_slice(array_values($variants), 0, 3);

                // empty variants
                $answers = ["a" => "", "b" => "", "c" => "", "d" => ""];

                // set right answer to random variant
                $randomIdx = array_rand($answers);
                $answers[$randomIdx] = $rightAnswer;
                $emptyVariants = array_filter($answers, fn($item) => empty($item));

                // set wrong answers to other variants
                $otherVariants = array_combine($emptyVariants, $variants);                   
                $j = 0;
                foreach ($answers as $key => $value) {

                    if(empty($value)){
                        $answers[$key] = ucwords($variants[$j]['name']);
                        $j++;
                    }
                    
                }
                $j = 0;
                
                // make question  
                $randQuestion = str_replace("{poytaxt}", ucwords($randomCapital), $randQuestion);
                // dd($randQuestion, $answers);
                $result[] = ["question" => $randomCapital, "fullQuestion" => $randQuestion, "variants" => $answers];
            }
        }

        return $result;

    }

}

