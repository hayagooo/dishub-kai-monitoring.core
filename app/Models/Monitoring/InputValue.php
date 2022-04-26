<?php

namespace App\Models\Monitoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InputValue extends Model
{
    use HasFactory;

    protected $table = 'monitoring_input_values';

    public const TYPE_CATEGORY = 'category';
    public const TYPE_OBJECT = 'object';
    public const TYPE_MONITORING = 'monitoring';

    public const FILE_IMAGE = 'image';
    public const FILE_DOCS = 'document';
    public const FILE_EXCEL = 'excel';
    public const FILE_PDF = 'pdf';
    public const FILE_PPT = 'ppt';

    protected $fillable = [
        'monitoring_input_id',
        'type',
        'monitoring_id',
        'string_value',
        'date_value',
        'time_value',
        'number_value',
        'file_value',
        'type_file',
        'text_value',
    ];

    public static function getAvailableType(): array
    {
        return [
            self::TYPE_CATEGORY,
            self::TYPE_OBJECT,
            self::TYPE_MONITORING,
        ];
    }

    public static function getAvailableExtension(): array
    {
        return [
            self::FILE_IMAGE,
            self::FILE_DOCS,
            self::FILE_PPT,
            self::FILE_EXCEL,
            self::FILE_PDF,
        ];
    }

    public function input(): BelongsTo
    {
        return $this->belongsTo(Input::class, 'monitoring_input_id', 'id');
    }

    public function monitoring(): BelongsTo
    {
        return $this->belongsTo(Monitoring::class, 'monitoring_id', 'id');
    }
}
