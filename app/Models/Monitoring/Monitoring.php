<?php

namespace App\Models\Monitoring;

use App\Models\Employee;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Monitoring extends Model
{
    use HasFactory;

    protected $table = 'monitorings';

    protected $fillable = [
        'monitoring_category_id',
        'monitoring_object_id',
        'title',
        'employee_id',
        'team_id',
        'description',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'monitoring_category_id', 'id');
    }

    public function object(): BelongsTo
    {
        return $this->belongsTo(ObjectData::class, 'monitoring_object_id', 'id');
    }

    public function input(): HasMany
    {
        return $this->hasMany(Input::class, 'monitoring_id', 'id');
    }

    public function image(): HasMany
    {
        return $this->hasMany(Image::class, 'monitoring_id', 'id');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }

    public function valueData(): HasMany
    {
        return $this->hasMany(InputValue::class, 'monitoring_input_id', 'id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function optionValue(): HasMany
    {
        return $this->hasMany(OptionValue::class, 'monitoring_id', 'id');
    }
}
