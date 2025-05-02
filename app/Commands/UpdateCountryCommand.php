<?php
namespace App\Commands;

use App\Models\Country;

class UpdateCountryCommand implements Command
{

    private Country $country;
    private $data;
    
    public function __construct(Country $country, $data) {
        $this->country = $country;
        $this->data = $data;
    }

    public function execute()
    {
        $this->country->update($this->data);
        return $this->country;
    }
}