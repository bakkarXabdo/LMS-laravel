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

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $collection = Collection::make();
        foreach (BookCopy::orderBy(Book::FOREIGN_KEY)->with('book')->get() as $key => $copy)
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

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            "الرقم",
            "الجرد",
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
}
