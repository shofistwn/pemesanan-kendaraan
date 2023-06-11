<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BookingsExport implements FromCollection, ShouldAutoSize, WithHeadings, WithStyles
{
  protected $bookings;

  public function __construct(Collection $bookings)
  {
    $this->bookings = $bookings;
  }

  public function collection()
  {
    return $this->bookings;
  }

  public function styles(Worksheet $sheet)
  {
    return [
      1 => [
        'font' => [
          'size' => 16
        ]
      ],
    ];
  }

  public function headings(): array
  {
    return [
      '#',
      'Driver',
      'Vehicle Type',
      'Vehicle Number',
      'First Approver',
      'Second Approver',
      'Status',
      'Date',
    ];
  }
}