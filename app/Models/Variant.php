<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Variant extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'default_price_amount',
        'stock',
    ];

    public function variants(): BelongsToMany
    {
        return $this->belongsToMany(Variant::class, 'variant_variant', 'selected_variant_id', 'affected_variant_id')->withPivot('affected_disabled', 'affected_price_amount_increase');
    }

    public function part(): BelongsTo
    {
        return $this->belongsTo(Part::class);
    }
}
