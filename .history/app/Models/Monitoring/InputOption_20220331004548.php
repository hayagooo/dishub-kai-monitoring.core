<?php

namespace App\Models\Monitoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InputOption extends Model
{
    use HasFactory;

    protected $table = 'monitoring_input_options';

    protected $fillable = [
        'monitoring_input_id',
        'value',
        'is_checked',
    ];
}
