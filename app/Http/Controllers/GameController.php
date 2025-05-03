<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Commands\CreateQuestionCommand;
use App\Commands\CheckQuestionsCommand;

use App\Services\CommandBus;
use Inertia\Inertia;


class GameController extends Controller
{

    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function question()
    {

        $countries = Country::select(['name', 'capital', 'population', 'continent'])->get();
        if(count($countries) <= 5){
            abort(400, "O'yin uchun kamida 5 ta savol bo'lishi kerak.");
        }

        $command = new CreateQuestionCommand($countries);
        $questions =  $this->commandBus->handle($command);

        return Inertia::render('Games/game', [
            "questions" => $questions
        ]);
    }


    public function submit(Request $requst)
    {
        $answers = $requst->answers;

        $command = new CheckQuestionsCommand($answers);
        $rightAnswers =  $this->commandBus->handle($command);

        return response()->json([
            "correct" => $rightAnswers
        ], 200);

    }


}

