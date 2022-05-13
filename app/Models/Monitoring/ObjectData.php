<?php

namespace App\Models\Monitoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ObjectData extends Model
{
    use HasFactory;

    protected $table = 'monitoring_objects';

    protected $fillable = [
        'name',
        'icon',
        'description',
    ];

    public function monitoring(): HasMany
    {
        return $this->hasMany(Monitoring::class, 'monitoring_object_id', 'id');
    }

    public function input(): HasMany
    {
        return $this->hasMany(Input::class, 'monitoring_object_id', 'id');
    }
}
