<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryRequest;
use App\Models\Country;
use App\Commands\CreateCountryCommand;
use App\Commands\UpdateCountryCommand;
use App\Commands\DeleteCountryCommand;
use App\Services\CommandBus;
use Inertia\Inertia;
use App\Commands\Command;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function index()
    {
        $countries = Country::where("author_id", auth("web")->user()->id)->get();
        return Inertia::render('Countries/index', [
            "countries" => $countries
        ]);
    }

    public function create()
    {
        return Inertia::render('Countries/create');
    }

    public function store(CountryRequest $request)
    {
        $data = $request->validated();
        $data['author_id'] = auth('web')->user()->id;;

        $command = new CreateCountryCommand($data);
        $this->commandBus->handle($command);

        return redirect()->route("country.index");
    }

    public function show(Country $country)
    {
        return Inertia::render("Countries/show", [
            "country" => $country
        ]);
    }

    public function edit(Request $request, Country $country)
    {

        if ($request->user()->cannot('update', $country)) {
            abort(403);
        }
    
        return Inertia::render("Countries/edit", [
            "country" => $country
        ]);
    }

    public function update(CountryRequest $request, Country $country)
    {
        $command = new UpdateCountryCommand($country, $request->validated());
        $this->commandBus->handle($command);

        return redirect()->route("country.index");
    }

    public function destroy(Request $request, Country $country)
    {

        if ($request->user()->cannot('update', $country)) {
            abort(403);
        }

        $command = new DeleteCountryCommand($country);
        $this->commandBus->handle($command);
        
        return redirect()->back();
    }
}