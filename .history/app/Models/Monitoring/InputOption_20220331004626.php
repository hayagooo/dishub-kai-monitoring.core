<?php

namespace App\Models\Monitoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InputOption extends Model
{
    use HasFactory;

    protected $table = 'monitoring_input_options';

    protected $fillable = [
        'monitoring_input_id',
        'value',
        'is_checked',
    ];

    public function input(): BelongsTo
    {
        return $this->belongsTo(Input::class, 'monitoring_input_id', 'id').
    }
}
