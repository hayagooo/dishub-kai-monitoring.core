<?php

namespace App\Models\Monitoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'monitoring_categories';

    protected $fillable = [
        'name',
        'icon',
        'description',
    ];
}
