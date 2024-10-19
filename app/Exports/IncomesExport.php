<?php

namespace App\Exports;

use App\Models\VehicleIncome;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class IncomesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return VehicleIncome::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Vehicle',
            'Amount',
            'Date',
            'Created At',
            'Updated At',
        ];
    }

    public function map($income): array
    {
        return [
            $income->id,
            $income->vehicle->name, // Assuming there's a relationship with Vehicle model
            $income->amount,
            $income->date,
            $income->created_at,
            $income->updated_at,
        ];
    }
}
