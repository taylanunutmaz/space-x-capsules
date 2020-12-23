<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capsule extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'capsule_serial',
        'capsule_id',
        'status',
        'original_launch',
        'original_launch_unix',
        'landings',
        'details',
        'reuse_count',
    ];

    public function getRouteKeyName()
    {
        return 'capsule_serial';
    }

    public function missions()
    {
        return $this->hasMany(Mission::class);
    }
}
