<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\EloquentRepository;

/**
 * ProductEloquentRepository class.
 */
class ProductEloquentRepository extends EloquentRepository implements ProductRepository
{
    /**
     * {@inheritdoc}
     */
    public function findById($id, $include): array
    {
        return Product::find($id)->with($include)->first()->toArray();
    }
}
