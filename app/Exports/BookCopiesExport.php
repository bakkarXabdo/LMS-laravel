<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromCollection;

class BookCopiesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $books = Book::query()->with("copies")->get();
        $exports = [[
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
            ]
        ];
        $i = 1;
        foreach ($books as $book) {
            foreach ($book->copies as $copy)
            {
                $exports[] = [
                    "الرقم" => $i++,
                    "الجرد" => $copy->InventoryId,
                    "الشفرة" => $copy->getKey(),
                    "العنوان" => $book->Title,
                    "المؤلف" => $book->Author,
                    "الناشر" => $book->Publisher,
                    "سنة النشر" => $book->ReleaseYear,
                    "السعر" => $book->Price,
                    "الإعارات الكلية" => strval($copy->TotalRentals),
                    "Isbn" => $book->Isbn
                ];
            }
        }
        return collect($exports);
    }
}
