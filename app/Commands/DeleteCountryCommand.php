<?php

namespace App\Commands;

use App\Models\Country;

class DeleteCountryCommand implements Command
{
    private Country $country;
    
    public function __construct(Country $country) {
        $this->country = $country;
    }
    
    public function execute() {
        return $this->country->delete();
    }
}
