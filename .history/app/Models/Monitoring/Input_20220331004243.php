<?php

namespace App\Models\Monitoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Input extends Model
{
    use HasFactory;

    protected $table = 'monitoring_inputs';

    public const TYPE_TEXT = 'text';
    public const TYPE_NUMBER = 'number';
    public const TYPE_SELECT = 'select';
    public const TYPE_CHECKBOX = 'checkbox';
    public const TYPE_RADIO = 'radio';

    protected $fillable = [
        'monitoring_id',
        'label',
        'type',
        'placeholder',
        'text',
        'number',
    ];

    public static function getAvailableType(): array
    {
        return [
            self::TYPE_TEXT,
            self::TYPE_NUMBER,
            self::TYPE_SELECT,
            self::TYPE_RADIO,
            self::TYPE_CHECKBOX,
        ];
    }

    public function monitoring(): BelongsTo
    {
        return $this->belongsTo(Monitoring::class, 'monitoring_id', 'id');
    }
}
