<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Capsule extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'capsule_serial' => $this->capsule_serial,
            'capsule_id' => $this->capsule_id,
            'status' => $this->status,
            'original_launch' => $this->original_launch,
            'original_launch_unix' => $this->original_launch_unix,
            'landings' => $this->landings,
            'details' => $this->details,
            'reuse_count' => $this->reuse_count,
            'missions' => Mission::collection($this->missions),
        ];
    }
}
