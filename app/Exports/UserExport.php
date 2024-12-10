<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\user;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserExport implements FromCollection, WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection,
    */
    public function collection()
    {
        return user::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Email',
            'role',
            'tanggal'
        ];
    }

    public function map($users): array
    {
        return [
            $users->id,
            $users->name,
            $users->email,
            $users->role,
            $users->created_at,
        ];
    }

}
