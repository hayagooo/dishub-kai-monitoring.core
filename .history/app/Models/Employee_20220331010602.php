<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
}


// $table->string('name');
//             $table->string('email');
//             $table->string('phone_number');
//             $table->string('division');
//             $table->string('branch');
//             $table->string('position');
//             $table->string('profession');
