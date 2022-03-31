<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'name',
        'phone_number',
        'division',
        'branch',
        'position',
        'profession',
    ];

    public function team(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'employee_teams', 'employee_id', 'team_id');
    }

    public function monitoring(): HasMany
    {
        return $this->hasMany(Monitoring::class, 'employee_id', 'id');
    }
}
