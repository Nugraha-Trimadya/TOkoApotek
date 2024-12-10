<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\order;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return order::with('user')->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Kasir',
            'Daftar Obat',
            'Nama Pembeli',
            'Total Harga',
            'Tanggal'
        ];
    }

    public function map($order): array
    {
        $daftarobat = "";
        foreach ($order->medicines as $key => $value) {
            $obat = $key+1 . ". " . $value['name_medicine'] . " (" . $value['qty'] . "pcs) Rp. " . number_format($value['total_price'], 0, ',', '.') ;
            $daftarobat.= $obat;
        }
        return [
            $order->id,
            $order->user->name,
            $daftarobat,
            $order->name_costumer,
            "Rp." . number_format($order->total_price, 0, ',', '.'),
            \Carbon\Carbon::parse($order['created_at'])->locale('id')->isoFormat('dddd, DD MMMM YYYY HH:mm:ss'),
        ];
    }
}
