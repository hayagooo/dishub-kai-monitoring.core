<?php

namespace App\Models\Monitoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
}
