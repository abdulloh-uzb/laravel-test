<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Country extends Model
{
    protected $fillable = ["name", "capital", "population", "continent", "author_id"];

    public function author(): BelongsTo
    {   
        return $this->belongsTo(User::class);
    }

}
