<?php

namespace App\Imports;

use App\Models\Employee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class EmployeeImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach($collection as $index => $item) {
            if($index == 0) continue;
            else {
                Employee::query()->create([
                    'name' => $item[0],
                    'email' => $item[1],
                    'phone_number' => $item[2],
                    'division' => $item[3],
                    'position' => $item[4],
                    'profession' => $item[5],
                ]);
            }
        }
    }
}
