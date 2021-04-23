<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BooksExport implements FromCollection, WithHeadings, WithColumnFormatting, WithColumnWidths
{
    use Exportable;
    public function __construct($booksCollection)
    {
        $this->data = $booksCollection;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $collection = collect([]);
        foreach ($this->data as $key => $book) {
            $collection->add([
                "الرقم" => $key,
                "الشفرة" => $book->getKey(),
                "العنوان" => $book->Title,
                "المؤلف" => $book->Author,
                "الناشر" => $book->Publisher,
                "سنة النشر" => $book->ReleaseYear,
                "السعر" => $book->Price,
                "الإعارات الكلية" => strval($book->TotalRentals),
                "Isbn" => $book->Isbn
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
    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 15,
            'C' => 35,
            'D' => 15,
            'E' => 15,
            'F' => 10,
            'G' => 10,
            'H' => 10,
            'I' => 15,
        ];
    }
}
