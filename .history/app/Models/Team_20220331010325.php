<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        return $this->belongsToMany(Employee::class, 'employee_teams', 'employee_id', 'team_id');
    }
}
