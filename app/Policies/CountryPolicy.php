<?php

namespace App\Policies;

use App\Models\Country;
use App\Models\User;

class CountryPolicy
{
    public function update(User $user, Country $country): bool
    {
        return $user->id === $country->author_id;
    }

    public function delete(User $user, Country $country): bool
    {
        return $user->id === $country->author_id;
    }
}
