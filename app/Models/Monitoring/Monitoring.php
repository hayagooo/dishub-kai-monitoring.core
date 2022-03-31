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
        'monitoring_category_subject_id',
        'name',
        'employee_id',
        'team_id',
        'description',
        'data',
    ];

    public function categoryObject(): BelongsTo
    {
        return $this->belongsTo(CategoryObject::class, 'monitoring_category_subject_id', 'id');
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

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
