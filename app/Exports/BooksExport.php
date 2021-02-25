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
        $books = Book::query()->with("copies")->get();
        $exports = [[
            "الرقم" => "الرقم",
            "الجرد" => "الجرد",
            "الشفرة" => "الشفرة",
            "العنوان" => "العنوان",
            "المؤلف" => "المؤلف",
            "الناشر" => "الناشر",
            "سنة النشر" => "سنة النشر",
            "السعر" => "السعر",
            "Isbn" => "Isbn",
            ]
        ];
        $i = 1;
        foreach ($books as $book) {
            foreach ($book->copies as $copy)
            {
                $exports[] = [
                    "الرقم" => $i++,
                    "الجرد" => $copy->InventoryId,
                    "الشفرة" => $copy->{BookCopy::KEY},
                    "العنوان" => $book->Title,
                    "المؤلف" => $book->Author,
                    "الناشر" => $book->Publisher,
                    "سنة النشر" => $book->ReleaseYear,
                    "السعر" => $book->Price,
                    "Isbn" => $book->Isbn
                ];
            }
        }
        return collect($exports);
    }
}
