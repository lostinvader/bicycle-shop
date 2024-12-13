<?php

namespace App\Repositories\Part;

/**
 * PartRepository interface.
 */
interface PartRepository
{
    /**
     * Get all parts.
     *
     * @param  string  $include  string
     */
    public function all($include): array;
}
