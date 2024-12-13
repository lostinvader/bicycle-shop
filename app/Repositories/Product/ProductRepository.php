<?php

namespace App\Repositories\Product;

/**
 * ProductRepository interface.
 */
interface ProductRepository
{
    /**
     * Get product by id.
     *
     * @param  int  $id  The product id
     * @param  string  $include  String
     */
    public function findById($id, $include): array;
}
