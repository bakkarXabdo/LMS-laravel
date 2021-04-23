<?php

namespace App\Exports;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\RentalHistory;
use App\Models\Student;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class HistoryExport implements FromCollection, WithHeadings, WithColumnFormatting, WithColumnWidths
{
    use Exportable;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $collection = collect([]);
        foreach ($this->data as $history) {
            $collection->add([
                "رقم العملية"          => $history->getKey(),
                "إسم المُنشئ"           => $history->CreatedBy,
                "إسم المُرجِع"           => $history->ReturnedBy,
                "شفرة النسخة"          => $history->BookCopyId,
                "عنوان النسخة"         => $history->BookTitle,
                "رقم الطالب"           => $history->StudentId,
                "إسم الطالب"           => $history->StudentName,
                "تاريخ الإعارة"         => $history->{RentalHistory::CREATED_AT},
                "تاريخ إنتهاء الإعارة" => $history->RentalExpiresAt,
                "تاريخ الإرجاع"         => $history->RentalReturnedAt,
            ]);
        }
        return $collection;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            "رقم العملية",
            "إسم المُنشئ",
            "إسم المُرجِع",
            "شفرة النسخة",
            "عنوان النسخة",
            "رقم الطالب",
            "إسم الطالب",
            "تاريخ الإعارة",
            "تاريخ إنتهاء الإعارة",
            "تاريخ الإرجاع",
        ];
    }
    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_NUMBER,
        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 15,
            'C' => 15,
            'D' => 15,
            'E' => 35,
            'F' => 15,
            'G' => 15,
            'H' => 20,
            'I' => 20,
            'J' => 20,
        ];
    }
}
