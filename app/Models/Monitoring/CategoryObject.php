<?php

namespace App\Models\Monitoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryObject extends Model
{
    use HasFactory;

    protected $table = 'monitoring_category_subject';

    protected $fillable = [
        'monitoring_category_id',
        'monitoring_object_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'monitoring_category_id', 'id');
    }

    public function object(): BelongsTo
    {
        return $this->belongsTo(ObjectData::class, 'monitoring_object_id', 'id');
    }

    public function monitoring(): HasMany
    {
        return $this->hasMany(Monitoring::class, 'monitoring_category_subject_id', 'id');
    }
}
