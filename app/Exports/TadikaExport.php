<?php

namespace App\Exports;

use App\Models\Tadika;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TadikaExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Tadika::with('owner')->get();
    }

    public function headings(): array
    {
        return [
            'Nama Tadika',
            'No. Pendaftaran',
            'Emel',
            'No. Telefon',
            'Alamat',
            'Daerah',
            'Negeri',
            'Poskod',
            'Nama Pemilik',
            'Emel Pemilik',
        ];
    }

    public function map($tadika): array
    {
        return [
            $tadika->tadika_name,
            $tadika->tadika_reg_no,
            $tadika->tadika_email,
            $tadika->tadika_phone,
            $tadika->tadika_address,
            $tadika->tadika_district,
            $tadika->tadika_state,
            $tadika->tadika_postcode,
            $tadika->owner->user_name ?? 'N/A',
            $tadika->owner->user_email ?? 'N/A',
        ];
    }
}
