<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Part extends Model
{
    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class);
    }
}
