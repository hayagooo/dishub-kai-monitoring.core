<?php

namespace App\Models\Monitoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $table = 'monitoring_categories';

    protected $fillable = [
        'name',
        'icon',
        'description',
    ];

    public function object(): BelongsToMany
    {
        return $this->belongsToMany(Category::class,
            'monitoring_category_subject',
            'monitoring_category_id',
            'monitoring_object_id'
        );
    }

    public function categoryObject(): HasMany
    {
        return $this->hasMany(CategoryObject::class, 'monitoring_category_id', 'id');
    }
}
