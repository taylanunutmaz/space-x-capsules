<?php

namespace Tests\Unit;

use App\CapsuleFilters;
use App\Models\Capsule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Tests\TestCase;

class QueryFiltersTest extends TestCase
{
    /**
     * filter() unit test for capsule.
     *
     * @return void
     */
    public function testCapsuleFilter()
    {
        foreach (CapsuleFilters::FILTERS as $filter) {
            // Add an fake filter with Str::random()
            $capsule_filter_attributes = Capsule::pluck($filter)->merge(collect(Str::random()));

            foreach ($capsule_filter_attributes as $attribute) {
                $request = Request::create('/api/capsules', 'GET', [$filter => $attribute]);
                $capsuleFilter = new CapsuleFilters($request);

                $capsule_statuses = Capsule::filter($capsuleFilter)->groupBy($filter)->pluck($filter);

                if ($capsule_statuses->isNotEmpty()) {
                    $this->assertEquals($capsule_statuses, collect($attribute));
                }
            }
        }
    }
}
