<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

class CapsuleFilters extends QueryFilters
{
    /**
     * Filter by status.
     *
     * @param  string $status
     * @return Builder
     */
    public function status($status)
    {
        return $this->builder->where('status', $status);
    }
}
