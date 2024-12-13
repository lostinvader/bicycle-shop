<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Part\PartRepository;
use App\Repositories\Variant\VariantRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $variants = resolve(VariantRepository::class)->all('part');

        return Inertia::render('Admin/Variants', [
            'variants' => $variants,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $parts = resolve(PartRepository::class)->all('variants.variants');
        $variant = resolve(VariantRepository::class)->findById($id, 'variants');

        return Inertia::render('Admin/Variant', [
            'parts' => $parts,
            'variant' => $variant,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'price' => 'required|integer',
            'stock' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $variant = resolve(VariantRepository::class)->update($id, [
            'name' => $request->name,
            'default_price_amount' => $request->price,
            'stock' => $request->stock,
        ]);

        $disabled = $request->disabled;

        $prices = array_filter($request->priceIncrease, 'strlen');

        $result1 = [];
        $result2 = [];

        foreach ($disabled as $key => $value) {
            $result1[$value] = ['affected_disabled' => 1];
        }

        foreach ($prices as $key => $value) {
            $result2[$key] = ['affected_price_amount_increase' => $value];
        }

        $result = array_replace_recursive($result1, $result2);

        $variant = resolve(VariantRepository::class)->syncVariants($id, $result);

        return back()->withErrors($validator)->withInput();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
