<?php

namespace App\Models\Monitoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Input extends Model
{
    use HasFactory;

    protected $table = 'monitoring_inputs';

    protected $fillable = [
        'monitoring_id',
        'label',
        'type',
        'placeholder',
        'text',
        'number',
    ];

    public function monitoring()
    {
        return $this->belongsTo(Monitoring::class, 'monitoring_id', 'id');
    }
}
