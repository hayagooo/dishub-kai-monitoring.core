<?php

namespace Database\Seeders;

use App\Imports\TeamImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class TeamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new TeamImport, 'database/seeders/data/team_data.xlsx');
    }
}
