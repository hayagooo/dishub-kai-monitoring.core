<?php

namespace App\Models\Monitoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjectData extends Model
{
    use HasFactory;

    protected $table = 'monitoring_objects';

    protected $fillable = [
        'name',
        'icon',
        'monitoring_category_id',
    ];
}
