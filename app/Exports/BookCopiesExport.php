<?php

namespace App\Exports;

use App\Models\Book;
use App\Models\BookCopy;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookCopiesExport implements FromCollection, WithHeadings
{
    use Exportable;


    public function __construct($copiesCollection)
    {
        $this->data = $copiesCollection;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $collection = Collection::make();
        foreach ($this->copiesCollection as $key => $copy)
        {
            $collection->add([
                "الرقم" => $key+1,
                "الجرد" => $copy->InventoryId,
                "الشفرة" => $copy->getKey(),
                "العنوان" => $copy->book->Title,
                "المؤلف" => $copy->book->Author,
                "الناشر" => $copy->book->Publisher,
                "سنة النشر" => $copy->book->ReleaseYear,
                "السعر" => $copy->book->Price,
                "الإعارات الكلية" => strval($copy->TotalRentals),
                "Isbn" => $copy->book->Isbn
            ]);
        }
        return $collection;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 15,
            'C' => 15,
            'D' => 35,
            'E' => 15,
            'F' => 10,
            'G' => 10,
            'H' => 10,
            'I' => 15,
        ];
    }
    public function headings(): array
    {
        return [
            "الرقم",
            "الشفرة",
            "العنوان",
            "المؤلف",
            "الناشر",
            "سنة النشر",
            "السعر",
            "الإعارات الكلية",
            "Isbn",
        ];
    }
    public function columnFormats(): array
    {
        return [

        ];
    }
}
