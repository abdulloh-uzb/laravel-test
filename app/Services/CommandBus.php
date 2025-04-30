<?php

namespace App\Services;

use App\Commands\Command;

class CommandBus
{
    public function handle(Command $command)
    {
        return $command->execute();
    }
}