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
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;

class BooksImport implements ToCollection
{
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
        $errors = [];
        $warnings = [];
        $responseView = view('errors.importError');
        if(!Cache::has("fileHash-".$GLOBALS["fileHash"])) {
            Cache::put("fileHash-".$GLOBALS["fileHash"], serialize($rows->all()), 5 * 60 * 60);
        }
        for($i = 0, $iMax = $rows->count(); $i < $iMax; $i++)
        {
            $rows[$i]["line"] = $i+1;
        }
        $headers = null;
        if(($dataOffset = request('startOffset')) > 0)
        {
            $headers = $rows[0];
            if(!is_numeric($dataOffset))
            {
                $this->error("بداية البيانات يجب أن يكون رقم (&) ليس رقم", [
                    $dataOffset
                ]);
            }
            $dataOffset = (int)$dataOffset - 1;
            $rows = $rows->slice($dataOffset);
        }
        $rows = $rows->map(function($book) use ($id_Publisher, $id_Author, $id_Isbn, $id_Price, $id_InventoryId, $id_ReleaseYear, $id_Title, $rows, $id_Code){
            // new parsed book
            $nbook = ["line" => $book["line"]];
            $nbook["ID"] = $this->safeGet($id_Code, $book);
            $nbook["IN"] = $this->safeGet($id_InventoryId, $book);
            $nbook["PU"] = $this->safeGet($id_Publisher, $book);
            $nbook["AU"] = $this->safeGet($id_Author, $book);
            $nbook["IS"] = $this->safeGet($id_Isbn, $book);
            $nbook["TI"] = $this->safeGet($id_Title, $book);
            $nbook["PR"] = $this->safeGet($id_Price, $book);
            $nbook["RY"] = $this->safeGet($id_ReleaseYear, $book);
            return $nbook;
        });
        $rows = $rows->filter(function($book){
            $inventory = $book["IN"];
            $id = $book["ID"];
            if($id === "شاغر" || $id === "الشفرة"
                || $inventory === "شاغر" || $inventory === "الجرد"
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
        $dbBooks = Book::query()->with('copies')->get();
        $dbBookCopies = BookCopy::all();
        $dbLanguages = BookLanguage::all();
        $dbCategories = Category::all();
        $rows = $rows->map(function($book)  use ($id_ReleaseYear, $id_Title, $id_Code, $id_Price, $dbCategories, $dbLanguages, &$errors){

            $line = $book["line"];
            $year = $book["RY"];
            if(isset($book["PR"]) && !is_numeric($book["PR"])) {
                $warnings[] = [
                    "message" => AppHelper::ArabicFormat("سعر الكتاب ليس رقم صحيحا, تم تجاهل القيمة (؟)",
                        [
                            $book["PR"]
                        ]),
                    "line" => $line,
                    "column" => $id_Price + 1
                ];
                $book["PR"] = null;
            }
            $v = $this->fixBookId($book["ID"]);
            if($v === null)
            {
                $val = $book["ID"];
                $col = $id_Code + 1;
                $errors[] = [
                    "message" => AppHelper::ArabicFormat("الشفرة غير صحيحة (؟)",
                        [
                            $val
                        ]),
                    "line" => $line,
                    "column" => $col
                ];
                $book["ID"] = "%error%" . Str::random();
            }else {
                $book["ID"] = $v;
                preg_match('/^[A-Za-z]+/', $v, $match);
                $bookCode = $match[0];
                if (strlen($bookCode) < 2) {
                    $errors[] = [
                        "message" => AppHelper::ArabicFormat("اللغة أو الصنف غير موجود في الشفرة (؟)", $bookCode),
                        "line" => $line,
                        "column" => $id_Code + 1
                    ];
                }else {
                    $bookRawLanguage = substr($bookCode, strlen($bookCode) - 1);
                    $bookRawCategory = substr($bookCode, 0, -1);
                    $bookLanguage = $dbLanguages->where('Code', $bookRawLanguage)->first();
                    $bookCategory = $dbCategories->where('Code', $bookRawCategory)->first();
                    if (!$bookLanguage) {
                        $errors[] = [
                            "message" => AppHelper::ArabicFormat("لغة الكتاب '؟' غير معروفة في الشفرة (؟) , الرجاء إدخال لغة جديدة في قاعدة البيانات بالرمز (؟)",
                                [
                                    $bookCode,
                                    $bookRawLanguage,
                                    $bookRawLanguage
                                ]),
                            "line" => $line,
                            "column" => $id_Code + 1
                        ];
                    }
                    if (!$bookCategory) {
                        $errors[] = [
                            "message" => AppHelper::ArabicFormat("صنف الكتاب '؟' غير مُعرف في الشفرة (؟) , الرجاء إدخال صنف جديد في قاعدة البيانات بالرمز (؟)",
                                [
                                    $bookCode,
                                    $bookRawCategory,
                                    $bookRawCategory
                                ]),
                            "line" => $line,
                            "column" => $id_Code + 1
                        ];
                    }
                    $book["LanguageId"] = $bookLanguage->getKey();
                    $book["CategoryId"] = $bookCategory->getKey();
                }
            }
            if(empty($book["TI"]))
            {
                $errors[] = [
                    "message" => "عنوان الكتاب غير موجود",
                    "line" => $line,
                    "column" => $id_Title + 1
                ];
            }
            if(isset($year) && (!is_int($year) || strlen($year) !== 4))
            {
                $errors[] = [
                    "message" => AppHelper::ArabicFormat("خطأ في سنة الاصدار (؟)", $year),
                    "line" => $line,
                    "column" => $id_ReleaseYear + 1
                ];
            }
            $book["%SI"] = !isset($book["IN"]) || $book["IN"] === "دون رقم جرد";
            return $book;
        });
        $repetitions = 0;
        if($onlyUnique)
        {
            $oldCount = $rows->count();
            $rows = $rows->unique("ID");
            $repetitions = $oldCount - $rows->count();
        }else {
            $duplicates = $rows->duplicates("ID");
            $duplicates = $duplicates->unique();
            if ($duplicates->count() > 0) {
                // we sort so we can do binary search later
                $id_sorted = collect($rows->sortBy("ID")->values());
                $count = count($id_sorted);
                foreach ($duplicates as $duplicate) {
                    $lines = [];
                    $index = AppHelper::binarySearch($id_sorted, 0, $count - 1, $duplicate, "ID");
                    $lines[] = $id_sorted[$index]["line"];
                    // check if we have more duplicates on the right
                    for($i = $index+1; $i < $count; $i++)
                    {
                        if($id_sorted[$i]["ID"] === $duplicate)
                        {
                            $lines[] = $id_sorted[$i]["line"];
                        }else{
                            break;
                        }
                    }
                    // if we have more on the left
                    for($i = $index-1; $i >= 0; $i--)
                    {
                        if($id_sorted[$i]["ID"] === $duplicate)
                        {
                            $lines[] =$id_sorted[$i]["line"];
                        }else{
                            break;
                        }
                    }
                    sort($lines);
                    $errors[] = [
                        "message" => AppHelper::ArabicFormat("الشفرة (؟) مكررة في الملف", $duplicate),
                        "line" => implode(' و ', $lines),
                        "column" => $id_Code + 1
                    ];
                }
                $rows = $rows->unique($id_Code);
            }
        }
        $inventorychecks = Collection::make();
        $idchecks = Collection::make();
        foreach ($rows as $book)
        {
            $Code = $book["ID"];
            if(strpos('%error%', $Code) !== 0)
            {
                $idchecks[] = $Code;
            }
            $InventoryId = $book["IN"];
            if (!$book["%SI"]) {
                $inventorychecks[] = $InventoryId;
            }
        }
        $idchecks_result = BookCopy::query()->whereIn(BookCopy::KEY, $idchecks)->select(BookCopy::KEY)->get();
        $inventorychecks_result = BookCopy::query()->whereIn("InventoryId", $inventorychecks)->select(BookCopy::KEY)->get();
        foreach ($idchecks_result as $error)
        {
            $id = $error->getKey();
            $line = $rows->where("ID", $id)->first()["line"];
            $errors[] = [
                "message" => AppHelper::ArabicFormat("النسخة (؟) موجودة في قاعدة البيانات مسبقا", $id),
                "line" => $line,
                "column" => $id_Code + 1
            ];
        }
        foreach ($inventorychecks_result as $error)
        {
            $inventory = $error->getKey();
            $line = $rows->where("IN", $inventory)->first()["line"];
            $errors[] = [
                "message" => AppHelper::ArabicFormat("رقم الجرد (؟) موجود في قاعدة البيانات مسبقا", $inventory),
                "line" => $line,
                "column" => $id_InventoryId + 1
            ];
        }
        if(count($errors) !== 0)
        {
            echo $responseView->with(["errors" => $errors, "warnings" => $warnings])->render();
            exit;
        }
        $rows = collect($rows->values());
        $rowsCount = $rows->count();
        $bookGroups = $rows->groupBy( function($book) {
            return preg_replace('/[^0-9A-Za-z]\d+$/', '', $book["ID"]);
        });
        unset($rows);
        DB::beginTransaction();
        try {
            foreach ($bookGroups as $bookId => $copiesGroup) {
                $rawBook = $copiesGroup[0];
                $dbBook = $dbBooks->find($bookId);
                if (!$dbBook) {
                    $outs = [
                        Book::KEY => $bookId,
                        Category::FOREIGN_KEY => $rawBook["CategoryId"],
                        BookLanguage::FOREIGN_KEY => $rawBook["LanguageId"]
                    ];
                    if ($rawBook["TI"]) {
                        $outs['Title'] = $rawBook["TI"];
                    }
                    if($b = $copiesGroup->whereNotNull("AU")->first())
                    {
                        $outs['Author'] = $b["AU"];
                    }
                    if($b = $copiesGroup->whereNotNull("PU")->first())
                    {
                        $outs['Publisher'] = $b["PU"];
                    }
                    if($b = $copiesGroup->whereNotNull("RY")->first())
                    {
                        $outs['ReleaseYear'] = $b["RY"];
                    }
                    if($b = $copiesGroup->whereNotNull("PR")->first())
                    {
                        $outs['Price'] = $b["PR"];
                    }
                    if($b = $copiesGroup->whereNotNull("IS")->first())
                    {
                        $outs['Isbn'] = $b["IS"];
                    }
                    Book::create($outs);
                }
                foreach ($copiesGroup as $copy) {
                    BookCopy::create([
                        BookCopy::KEY => $copy["ID"],
                        Book::FOREIGN_KEY => $bookId,
                        "InventoryId" => $copy["%SI"] ? null : $copy["IN"]
                    ]);
                }
            }
            DB::commit();
        }catch (\Exception $e)
        {
            DB::rollBack();
            echo $responseView->with(["headMessage" => "حدث خطأ إدخال في قاعدة البيانات ,الخطأ التقني:",
                "code" => $e->getMessage(),
                "errors" => $errors,
                "warnings" => $warnings
            ])->render();
            exit;
        }
        echo $responseView->with(["headMessage" =>
            AppHelper::ArabicFormat("تم إدخال ؟ نُسخة, ؟ كتاب , تجاهل ل ؟ نُسخة مكررة", [
                $rowsCount,
                $bookGroups->count(),
                $repetitions
            ]),
            "errors" => $errors,
            "warnings" => $warnings
        ])->render();
        exit;
        // self::$sheetNumber++;
    }
    private function safeGet($key, $array)
    {
        $v = $key >= 0 ? trim($array[$key]) : null;
        return empty($v) ? null : $v;
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
        $new = preg_replace('/\/0/', '/', $new);
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
