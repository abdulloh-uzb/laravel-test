<?php

namespace App\Commands;

use App\Models\Country;

class CreateCountryCommand implements Command  
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function execute()
    {
        return Country::create($this->data);
    }
}
