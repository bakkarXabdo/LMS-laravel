<?php

namespace App\Imports;

use App\Helpers\AppHelper;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\BookLanguage;
use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class BooksImport implements ToCollection
{
    private $rowsDef;
    private static $sheetNumber = 1;

    public function __construct()
    {

    }

    public function collection(Collection $rows)
    {
        $id_InventoryId = (int)(request('pos.InventoryId')) - 1;
        $id_Code = (int)(request('pos.Code')) - 1;
        $id_Title = (int)(request('pos.Title')) - 1;
        $id_Author = (int)(request('pos.Author')) - 1;
        $id_Publisher = (int)(request('pos.Publisher')) - 1;
        $id_ReleaseYear = (int)(request('pos.ReleaseYear')) - 1;
        $id_Price = (int)(request('pos.Price')) - 1;
        $id_Isbn = (int)(request('pos.Isbn')) - 1;
        $onlyUnique = (bool) request('unique');
        if(!Cache::has("fileHash-".$GLOBALS["fileHash"])) {
            Cache::put("fileHash-".$GLOBALS["fileHash"], serialize($rows->all()), 5 * 60 * 60);
        }
        for($i = 0, $iMax = $rows->count(); $i < $iMax; $i++)
        {
            $rows[$i]["line"] = $i+1;
        }
        if(($dataOffset = request('startOffset')) > 0)
        {
            if(!is_numeric($dataOffset))
            {
                $this->error("بداية البيانات يجب أن يكون رقم (&) ليس رقم", [
                    $dataOffset
                ]);
            }
            $dataOffset = (int)$dataOffset - 1;
            $rows = $rows->slice($dataOffset);
        }

        $rows = $rows->filter(static function($book) use ($id_InventoryId, $id_Code, $id_Author, $id_Isbn, $id_Price, $id_Publisher, $id_ReleaseYear, $id_Title) {
            if($book[$id_Code] === "شاغر" || $book[$id_Code] === "الشفرة"
                || $book[$id_InventoryId] === "شاغر" || $book[$id_InventoryId] === "الجرد"
            )
            {
                return false;
            }
            foreach ($book as $key => $v)
            {
                if($key !== "line" && !empty($v))
                {
                    return true;
                }
            }
            return false;
        });
        // fix all errors in the copy code
        // eg: MF 14/49 becomes MF/14/49
        // eg: MF/ 14 49 becomes MF/14/49
        $rows = $rows->map(function($book) use ($rows, $id_Code){
            $v = $this->fixBookId($book[$id_Code]);
            if($v === null)
            {
                $val = $book[$id_Code];
                $col = $id_Code + 1;
                $this->error("الشفرة غير صحيحة (&) , السطر & ,العمود &", [
                    $val, $book["line"], $col
                ]);
            }
            $book[$id_Code] = $v;
            return $book;
        });
        if($onlyUnique)
        {
            $rows = $rows->unique($id_Code);
        }else {
            $duplicates = $rows->duplicates($id_Code);
            $duplicates = $duplicates->unique();
            if ($duplicates->count() > 0) {
                $response = "<div dir='rtl'>";
                $response .= "يوجد شفرات مكررة في الملف<br>";
                $dups = Collection::make();
                foreach ($duplicates as $duplicate) {
                    $dups->add($rows->where($id_Code, $duplicate));
                }
                foreach ($dups as $dup) {
                    $response .= AppHelper::ArabicFormat("الشفرة (؟) مكررة في السطور: ", [$dup->first()[$id_Code]]);
                    foreach ($dup as $du) {
                        $response .= $du["line"] . "  ";
                    }
                    $response .= "<br>";
                }
                echo $response . "</div>";
                exit;
            }
        }
        $rows = collect($rows->values());
        // if we find an error in the data we exit the script with a message
        foreach ($rows as $key => $book)
        {
            $line = $key + 1;
            $id = trim($book[$id_Code]);
            $title = $book[$id_Title];
            $year = $this->safeGet($id_ReleaseYear, $book);
            if(!$this->checkRawBookId($id))
            {
                $val = $id;
                $col = $id_Code + 1;
                $this->error("الشفرة غير صحيحة (&) , السطر & ,العمود &", [
                    $val, $line, $col
                ]);
            }
            if(empty(trim($title)))
            {
                $col = $id_Title + 1;
                $this->error("عنوان الكتاب غير موجود , السطر & ,العمود &", [
                    $line, $col
                ]);
            }
            if(!empty($year) && (!is_int($year) || strlen($year) !== 4))
            {
                $val = $year;
                $col = $id_ReleaseYear + 1;
                $this->error("خطأ في سنة الاصدار (&) , السطر & ,العمود &", [
                    $val, $line, $col
                ]);
            }
        }
        $rawBooks = collect($rows->all());
        $bookGroups = $rawBooks->groupBy( function($book) use ($id_Code) {
            return preg_replace('/[^0-9A-Za-z]\d+$/', '', $book[$id_Code]);
        });
        $dbBooks = Book::query()->with('copies')->get();
        $dbBookCopies = BookCopy::all();
        $dbLanguages = BookLanguage::all();
        $dbCategories = Category::all();
        $repetitions = 0;

        Db::beginTransaction();
        try {
            foreach ($bookGroups as $bookId => $copiesGroup) {
                $rawBook = $copiesGroup[0];
                $dbBook = $dbBooks->find($bookId);
                preg_match('/^[A-Za-z]+/', $bookId, $match);
                $bookCode = $match[0];
                $line = $copiesGroup[0]["line"];
                if (strlen($bookCode) < 2) {
                    $val = $bookCode;
                    $col = $id_Code + 1;
                    $this->error("اللغة أو الصنف غير موجود في الشفرة (&) , السطر & ,العمود &", [
                        $val, $line, $col
                    ]);
                }
                $bookRawLanguage = substr($bookCode, strlen($bookCode) - 1);
                $bookRawCategory = substr($bookCode, 0, -1);
                $bookLanguage = $dbLanguages->where('Code', $bookRawLanguage)->first();
                $bookCategory = $dbCategories->where('Code', $bookRawCategory)->first();
                if (!$bookLanguage) {
                    $val = $bookCode;
                    $col = $id_Code + 1;
                    $this->error("لغة الكتاب & غير معروفة في الشفرة (&) , السطر & ,العمود &, الرجاء إدخال لغة جديدة في قاعدة البيانات بالرمز (&)", [
                        $bookRawLanguage, $val, $line, $col, $bookRawLanguage
                    ]);
                }
                if (!$bookCategory) {
                    $val = $bookCode;
                    $col = $id_Code + 1;
                    $this->error("صنف الكتاب & غير مُعرف في الشفرة (&) , السطر & ,العمود &, الرجاء إدخال صنف جديد في قاعدة البيانات بالرمز (&)", [
                        $bookRawCategory, $val, $line, $col, $bookRawCategory
                    ]);
                }
                if (!$dbBook) {
                    $outs = [
                        Book::KEY => $bookId,
                        Category::FOREIGN_KEY => $bookCategory->getKey(),
                        BookLanguage::FOREIGN_KEY => $bookLanguage->getKey()
                    ];
                    if ($v = $this->safeGet($id_Title, $rawBook)) {
                        $outs['Title'] = $v;
                    }
                    if ($v = $this->safeGet($id_Author, $rawBook)) {
                        $outs['Author'] = $v;
                    }
                    if ($v = $this->safeGet($id_Publisher, $rawBook)) {
                        $outs['Publisher'] = $v;
                    }
                    if ($v = $this->safeGet($id_ReleaseYear, $rawBook)) {
                        $outs['ReleaseYear'] = $v;
                    }
                    if ($v = $this->safeGet($id_Price, $rawBook)) {
                        $outs['Price'] = $v;
                    }
                    if ($v = $this->safeGet($id_Isbn, $rawBook)) {
                        $outs['Isbn'] = $v;
                    }
                    Book::create($outs);
                }
                $dbCopies = $dbBook ? $dbBook->copies : null;
                foreach ($copiesGroup as $copy) {
                    $line = $copy["line"];
                    $Code = $copy[$id_Code];
                    $InventoryId = trim($copy[$id_InventoryId]);
                    if (!empty($InventoryId) && $dbBookCopies->where('InventoryId', $InventoryId)->isNotEmpty()) {
                        $this->error("رقم الجرد (&) موجود في قاعدة البيانات مسبقا, السطر & ,العمود &", [
                            $InventoryId, $line, $id_InventoryId
                        ]);
                    }
                    if ($dbCopies && $dbCopies->find($Code)) {
                        $this->error("النسخة (&) موجودة في قاعدة البيانات مسبقا, السطر & ,العمود &", [
                            $Code, $line, $id_Code
                        ]);
                    }
                    $_inventoryId = $copy[$id_InventoryId];
                    $_inventoryId = $_inventoryId === "دون رقم جرد" ? null : $_inventoryId;
                    BookCopy::create([
                        BookCopy::KEY => $Code,
                        Book::FOREIGN_KEY => $bookId,
                        "InventoryId" => $_inventoryId
                    ]);
                }
            }
            Db::commit();
        }catch (\Exception $e)
        {
            Db::rollBack();
            echo "حدث خطأ غير متوقع<br>";
            echo $e->getMessage();
        }
        echo "تم إدخال البيانات";
        echo $rows->count();

        exit;
        // self::$sheetNumber++;
    }
    private function safeGet($key, $array)
    {
        return $key >= 0 ? trim($array[$key]) : null;
    }
    private function fixBookId($raw)
    {
        $new = preg_replace('/\s/', '', preg_replace('/[^\dA-Za-z]+(?=\d+)/', '/', $raw));
        if(preg_match('/^[A-Za-z]+\d+\/\d+$/', $new))
        {
            $fixed = "";
            preg_match('/^[A-Za-z]+/', $new, $m);
            $fixed .= $m[0];
            preg_match('/\d+\/\d+$/', $new, $m);
            $fixed .= "/" . $m[0];
            $new = $fixed;
        }
        return $this->checkBookId($new) ? $new : null;
    }
    private function checkBookId($raw)
    {
        return preg_match('/^[A-Za-z]+\/\d+\/\d+$/', $raw);
    }
    private function checkRawBookId($raw)
    {
        return preg_match('/^[A-Za-z][A-Za-z\s\/\-]*\d+[^0-9A-Za-z]\d+$/', $raw);
    }
    private function error($message, $vals)
    {
        echo "<p dir='rtl'>" . vsprintf(str_replace('&', '%s', $message), $vals) . "</p>";
        exit;
    }
}
