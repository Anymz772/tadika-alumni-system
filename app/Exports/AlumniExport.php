<?php

namespace App\Exports;

use App\Models\Alumni;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AlumniExport implements FromCollection, WithHeadings, WithMapping
{
    protected $tadikaId;

    // Pass the Tadika ID through the constructor so owners only download their own data
    // Made nullable to allow exporting all alumni for admin
    public function __construct($tadikaId = null)
    {
        $this->tadikaId = $tadikaId;
    }

    public function collection()
    {
        $query = Alumni::query();

        if ($this->tadikaId) {
            $query->where('tadika_id', $this->tadikaId);
        }

        return $query->orderBy('grad_year', 'desc')->get();
    }

    // Define the Excel column headers
    public function headings(): array
    {
        return [
            'Nama',
            'No. K/P',
            'E-mel',
            'No. Telefon',
            'Tahun Graduasi',
            'Jantina',
            'Status',
            'Institusi / Syarikat'
        ];
    }

    // Map the database fields to the corresponding columns
    public function map($alumni): array
    {
        return [
            $alumni->alumni_name,
            $alumni->alumni_ic,
            $alumni->alumni_email,
            $alumni->alumni_phone,
            $alumni->grad_year,
            ucfirst($alumni->gender),
            ucfirst($alumni->alumni_status),
            // Display institution if studying, company if working
            $alumni->alumni_status === 'studying' ? $alumni->institution : $alumni->company,
        ];
    }
}