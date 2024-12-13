<?php

namespace App\Http\Controllers;

use App\Repositories\Product\ProductRepository;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = resolve(ProductRepository::class)->findById($id, 'parts.variants.variants');

        return Inertia::render('Product', [
            'product' => $product,
        ]);

    }
}
