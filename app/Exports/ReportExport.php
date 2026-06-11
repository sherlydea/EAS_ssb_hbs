<?php

namespace App\Exports;

use App\Models\TagihanSpp;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Bulan',
            'Tahun',
            'Nominal',
            'Status'
        ];
    }

    public function collection()
    {
        return TagihanSpp::with('siswa')
            ->get()
            ->map(function ($item) {
                return [
                    $item->siswa->nama ?? '-',
                    $item->bulan,
                    $item->tahun,
                    $item->nominal,
                    $item->status
                ];
            });
    }
}