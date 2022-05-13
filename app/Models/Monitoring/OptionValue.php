<?php

namespace App\Models\Monitoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OptionValue extends Model
{
    use HasFactory;

    protected $table = 'monitoring_option_values';

    protected $fillable = [
        'monitoring_id',
        'monitoring_input_id',
        'value',
        'monitoring_input_option_id'
    ];

    public function input(): BelongsTo
    {
        return $this->belongsTo(Input::class, 'monitoring_input_id', 'id');
    }

    public function monitoring(): BelongsTo
    {
        return $this->belongsTo(Monitoring::class, 'monitoring_id', 'id');
    }

    public function option()
    {
        return $this->belongsTo(InputOption::class, 'monitoring_input_option_id', 'id');
    }
}
