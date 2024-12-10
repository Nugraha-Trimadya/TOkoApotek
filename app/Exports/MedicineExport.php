<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Medicine;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MedicineExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Medicine::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama obat',
            'tipe',
            'harga',
            'stock'
        ];
    }

    public function map($medicines): array
    {
        return [
            $medicines->id,
            $medicines->name,
            $medicines->type,
            $medicines->price,
            $medicines->stock,
        ];
    }
}
