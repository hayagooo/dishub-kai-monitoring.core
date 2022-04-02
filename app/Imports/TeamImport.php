<?php

namespace App\Imports;

use App\Models\Team;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;

class TeamImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach($collection as $index => $item) {
            Log::debug($item);
            if($index == 0) continue;
            else {
                Team::query()->create([
                    'name' => $item[0],
                    'goals' => $item[1],
                    'note' => $item[2],
                    'description' => $item[3],
                ]);
            }
        }
    }
}
