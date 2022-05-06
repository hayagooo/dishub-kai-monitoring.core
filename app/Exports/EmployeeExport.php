<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeeExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Employee::all();
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
            'email',
            'phone_number',
            'division',
            'position',
            'profession'
        ];
    }

    public function map($employee): array
    {
        return [
            $employee->name,
            $employee->email,
            $employee->phone_number,
            $employee->division,
            $employee->position,
            $employee->profession,
        ];
    }
}
