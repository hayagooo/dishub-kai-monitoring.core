<?php

namespace App\Exports;

use App\Models\Team;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TeamExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Team::all();
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            0 => ['font' => ['bold' => true]]
        ];
    }

    public function headings(): array
    {
        return [
            'name',
            'goals',
            'note',
            'description'
        ];
    }

    public function map($team): array
    {
        return [
            $team->name,
            strip_tags($team->goals),
            strip_tags($team->note),
            strip_tags($team->description),
        ];
    }
}
