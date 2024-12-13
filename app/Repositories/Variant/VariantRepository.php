<?php

namespace App\Repositories\Variant;

/**
 * VariantRepository interface.
 */
interface VariantRepository
{
    /**
     * Get all variants.
     *
     * @param  string  $include  string
     * @return array
     */
    public function all($include);

    /**
     * Get Variant by id.
     *
     * @param  int  $id  The variant id
     * @param  string  $include  String
     */
    public function findById($id, $include): array;

    /**
     * Update Variant values using id.
     *
     * @param  int  $id  The Variant id
     * @param  array  $data  fields to update
     * @return mixed
     */
    public function update($id, $data);

    /**
     * Sync Variant Variants using the id.
     *
     * @param  int  $id  The Variant id
     * @param  array  $data  fields to update
     */
    public function syncVariants($id, $data): array;
}
