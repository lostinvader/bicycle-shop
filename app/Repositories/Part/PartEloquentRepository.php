<?php

namespace App\Repositories\Part;

use App\Models\Part;
use App\Repositories\EloquentRepository;

/**
 * PartEloquentRepository class.
 */
class PartEloquentRepository extends EloquentRepository implements PartRepository
{
    /**
     * {@inheritdoc}
     */
    public function all($include): array
    {
        return Part::with($include)->get()->toArray();
    }
}
