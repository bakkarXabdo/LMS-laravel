<?php

namespace App\Exports;

use App\Models\BookCopy;
use Illuminate\Filesystem\Cache;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Book;

class BooksExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $books = Book::all();
        $exports = [[
            "الرقم",
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
            $exports[] = [
                "الرقم" => $i++,
                "الشفرة" => $book->getKey(),
                "العنوان" => $book->Title,
                "المؤلف" => $book->Author,
                "الناشر" => $book->Publisher,
                "سنة النشر" => $book->ReleaseYear,
                "السعر" => $book->Price,
                "الإعارات الكلية" => strval($book->TotalRentals),
                "Isbn" => $book->Isbn
            ];
        }
        return collect($exports);
    }
}
