<?php

namespace App\Exports;

use App\Models\RentalHistory;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HistoryExport implements FromCollection, WithHeadings
{
    use Exportable;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = RentalHistory::query()->whereBetween(RentalHistory::CREATED_AT, [$this->start, $this->end])->get();
        $collection = collect([]);
        foreach ($data as $history) {
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
}
