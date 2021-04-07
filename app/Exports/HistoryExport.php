<?php

namespace App\Exports;

use App\Models\RentalHistory;
use Maatwebsite\Excel\Concerns\FromCollection;

class HistoryExport implements FromCollection
{

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
        $exports = collect();
        $exports[] = [
            "رقم العملية"          => "رقم العملية",
            "شفرة النسخة"          => "شفرة النسخة",
            "عنوان النسخة"         => "عنوان النسخة",
            "رقم الطالب"           => "رقم الطالب",
            "إسم الطالب"           => "إسم الطالب",
            "تاريخ الإعارة"         => "تاريخ الإعارة",
            "تاريخ إنتهاء الإعارة" => "تاريخ إنتهاء الإعارة",
            "تاريخ الإرجاع"         => "تاريخ الإرجاع",
        ];
        foreach ($data as $history) {
            $exports[] = [
                "رقم العملية"          => $history->getKey(),
                "شفرة النسخة"          => $history->BookCopyId,
                "عنوان النسخة"         => $history->BookTitle,
                "رقم الطالب"           => $history->StudentId,
                "إسم الطالب"           => $history->StudentName,
                "تاريخ الإعارة"         => $history->{RentalHistory::CREATED_AT},
                "تاريخ إنتهاء الإعارة" => $history->RentalExpiresAt,
                "تاريخ الإرجاع"         => $history->RentalReturnedAt,
            ];
        }
        return collect($exports);
    }
}
