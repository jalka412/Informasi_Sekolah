<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;

class SiswaTemplateExport implements WithHeadings
{
    public function headings(): array
    {
        return [
        'Nama',
        'NIS',
        'Kelas',
        'Jenis Kelamin', // (Isi dengan L atau P)
        'Telp', 
        'Alamat',
    ];
    }
}