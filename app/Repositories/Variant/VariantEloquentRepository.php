<?php

namespace App\Repositories\Variant;

use App\Models\Variant;
use App\Repositories\EloquentRepository;

/**
 * VariantEloquentRepository class.
 */
class VariantEloquentRepository extends EloquentRepository implements VariantRepository
{
    /**
     * {@inheritdoc}
     */
    public function all($include): array
    {
        return Variant::with($include)->get()->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function findById($id, $include): array
    {
        return Variant::with($include)->find($id)->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, $data)
    {
        return Variant::find($id)->update($data);
    }

    /**
     * {@inheritdoc}
     */
    public function syncVariants($id, $data): array
    {
        return Variant::find($id)->variants()->sync($data);
    }
}
