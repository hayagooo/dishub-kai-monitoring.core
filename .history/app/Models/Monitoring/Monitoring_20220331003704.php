<?php

namespace App\Models\Monitoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
