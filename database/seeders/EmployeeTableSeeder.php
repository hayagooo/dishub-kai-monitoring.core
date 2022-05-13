<?php

namespace Database\Seeders;

use App\Imports\EmployeeImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new EmployeeImport, 'database/seeders/data/employee_data.xlsx');
    }
}
