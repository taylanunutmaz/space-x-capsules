<?php

namespace App\Http\Controllers\Api;

use App\CapsuleFilters;
use App\Http\Controllers\Controller;
use App\Http\Resources\Capsule as CapsuleResource;
use App\Models\Capsule;

class CapsuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CapsuleFilters $filters)
    {
        return CapsuleResource::collection(Capsule::with('missions')->filter($filters)->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Capsule  $capsule
     * @return \Illuminate\Http\Response
     */
    public function show(Capsule $capsule)
    {
        return new CapsuleResource($capsule->load('missions'));
    }
}
