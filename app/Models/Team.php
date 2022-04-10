<?php

namespace App\Models;

use App\Models\Monitoring\Monitoring;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasFactory;

    protected $table = 'teams';

    protected $fillable = [
        'name',
        'goals',
        'note',
        'description',
    ];

    public function employee(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'employee_teams', 'team_id', 'employee_id');
    }

    public function monitoring(): HasMany
    {
        return $this->hasMany(Monitoring::class, 'team_id', 'id');
    }
}
