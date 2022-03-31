<?php

namespace App\Models\Monitoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Monitoring extends Model
{
    use HasFactory;

    protected $table = 'monitorings';

    protected $fillable = [
        'monitoring_object_id',
        'name',
        'user_id',
        'description',
        'data',
    ];

    public function object(): BelongsTo
    {
        return $this->belongsTo(ObjectData::class, 'monitoring_object_id', 'id');
    }

    public function input(): HasMany
    {
        return $this->hasMany(Input::class, 'monitoring_id', 'id');
    }

    public function image(): HasMany
    {
        return $this->hasMany(Image::class, 'monitoring_id', 'id');
    }
}
