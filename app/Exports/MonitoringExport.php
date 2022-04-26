<?php

namespace App\Exports;

use App\Exports\Sheet\MonitoringPerMonthSheet;
use App\Models\Monitoring\Monitoring ;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MonitoringExport implements WithMultipleSheets
{
    use Exportable;

    public $category_id;
    public $object_id;

    public function __construct(mixed $category_id, mixed $object_id)
    {
        $this->category_id = $category_id;
        $this->object_id = $object_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        $sheets = [];
        $arrYears = [];
        $monitorings = Monitoring::query()->get();
        foreach($monitorings as $item) {
            $monitoring = Monitoring::query()->find($item->id);
            $arrYears[] = Carbon::parse($monitoring->created_at)->year;
        }
        $years = array_unique($arrYears);
        foreach($years as $year) {
            $sheets[] = new MonitoringPerMonthSheet($year, $this->category_id, $this->object_id);
        }
        return $sheets;
    }
}
