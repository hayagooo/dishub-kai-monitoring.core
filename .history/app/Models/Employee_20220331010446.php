<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}


// $table->string('name');
//             $table->string('email');
//             $table->string('phone_number');
//             $table->string('division');
//             $table->string('branch');
//             $table->string('position');
//             $table->string('profession');
