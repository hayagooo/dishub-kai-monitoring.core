<?php

namespace App\Models\Monitoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InputValue extends Model
{
    use HasFactory;

    protected $table = 'monitoring_input_values';

    protected $fillable = [
        'monitoring_input_id',
        'monitoring_id',
        'string_value',
        'date_value',
        'time_value',
        'number_value',
        'file_value',
    ];

    public function input(): BelongsTo
    {
        return $this->belongsTo(Input::class, 'monitoring_input_id', 'id');
    }

    public function monitoring(): BelongsTo
    {
        return $this->belongsTo(Monitoring::class, 'monitoring_id', 'id');
    }
}
