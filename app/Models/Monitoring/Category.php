<?php

namespace App\Models\Monitoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function monitoring(): HasMany
    {
        return $this->hasMany(Monitoring::class, 'monitoring_category_id', 'id');
    }

    public function input(): HasMany
    {
        return $this->hasMany(Input::class, 'monitoring_category_id', 'id');
    }
}
