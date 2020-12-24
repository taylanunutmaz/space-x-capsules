<?php

namespace App\Http\Controllers\Api;

use App\CapsuleFilters;
use App\Http\Controllers\Controller;
use App\Http\Resources\Capsule as CapsuleResource;
use App\Models\Capsule;

class CapsuleController extends Controller
{
    /**
     * @OA\Get (
     *     path="/api/capsules",
     *     @OA\Parameter(
     *          name="status",
     *          description="Status Filter",
     *          required=false,
     *          in="query",
     *      ),
     *     @OA\Response(response="200", description="Display a listing of capsules.", @OA\JsonContent()),
     *     security={
     *         {
     *              "bearerAuth": {},
     *              "passport": {},
     *          }
     *     }
     * )
     * @return mixed
     */
    public function index(CapsuleFilters $filters)
    {
        return CapsuleResource::collection(Capsule::with('missions')->filter($filters)->get());
    }

    /**
     * @OA\Get (
     *     path="/api/capsules/{capsule_serial}",
     *     @OA\Parameter(
     *          name="capsule_serial",
     *          description="Capsule Serial",
     *          required=true,
     *          in="path",
     *      ),
     *     @OA\Response(response="200", description="Display a capsules.", @OA\JsonContent()),
     *     security={
     *         {
     *              "bearerAuth": {},
     *              "passport": {},
     *          }
     *     }
     * )
     * @param  \App\Models\Capsule  $capsule
     * @return mixed
     */
    public function show(Capsule $capsule)
    {
        return new CapsuleResource($capsule->load('missions'));
    }
}
