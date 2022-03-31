<?php

namespace App\Models\Monitoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ObjectData extends Model
{
    use HasFactory;

    protected $table = 'monitoring_objects';

    protected $fillable = [
        'name',
        'icon',
    ];

    public function category(): BelongsToMany
    {
        return $this->belongsToMany(Category::class,
            'monitoring_category_monitoring_object',
            'monitoring_category_id',
            'monitoring_object_id'
    );
    }
}
