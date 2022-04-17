<?php

namespace App\Models\Monitoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Input extends Model
{
    use HasFactory;

    protected $table = 'monitoring_inputs';

    public const TYPE_TEXT = 'text';
    public const TYPE_TEXTAREA = 'textarea';
    public const TYPE_NUMBER = 'number';
    public const TYPE_DROPDOWN = 'dropdown';
    public const TYPE_CHECKBOX = 'checkbox';
    public const TYPE_RADIO = 'radio';
    public const TYPE_DATE = 'date';
    public const TYPE_TIME = 'time';
    public const TYPE_IMAGE = 'image';
    public const TYPE_FILE = 'file';
    public const TYPE_YOUTUBE = 'media-youtube';
    public const TYPE_DESCRIPTION = 'description';

    protected $fillable = [
        'monitoring_category_id',
        'monitoring_object_id',
        'monitoring_id',
        'image',
        'is_required',
        'label',
        'link',
        'type',
        'placeholder',
        'description',
    ];

    public static function getAvailableType(): array
    {
        return [
            self::TYPE_TEXT,
            self::TYPE_TEXTAREA,
            self::TYPE_NUMBER,
            self::TYPE_DROPDOWN,
            self::TYPE_CHECKBOX,
            self::TYPE_RADIO,
            self::TYPE_DATE,
            self::TYPE_TIME,
            self::TYPE_IMAGE,
            self::TYPE_FILE,
            self::TYPE_YOUTUBE,
            self::TYPE_DESCRIPTION,
        ];
    }

    public function monitoring(): BelongsTo
    {
        return $this->belongsTo(Monitoring::class, 'monitoring_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'monitoring_category_id', 'id');
    }

    public function object(): BelongsTo
    {
        return $this->belongsTo(ObjectData::class, 'monitoring_object_id', 'id');
    }

    public function value(): HasMany
    {
        return $this->hasMany(InputValue::class, 'monitoring_input_id', 'id');
    }

    public function option(): HasMany
    {
        return $this->hasMany(InputOption::class, 'monitoring_input_id', 'id');
    }
}
