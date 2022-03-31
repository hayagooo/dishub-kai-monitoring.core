<?php

namespace App\Models\Monitoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryObject extends Model
{
    use HasFactory;

    protected $table = 'monitoring_category_subject';

    protected $fillable = [
        'monitoring_category_id',
        'monitoring_object_id'
    ];
}
