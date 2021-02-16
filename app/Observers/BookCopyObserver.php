<?php

namespace App\Observers;

use App\Models\Book;
use App\Models\BookCopy;
use Illuminate\Support\Facades\DB;

class BookCopyObserver
{
    /**
     * Handle the BookCopy "created" event.
     *
     * @param  \App\Models\BookCopy  $bookCopy
     * @return void
     */
    public function created(BookCopy $bookCopy)
    {
        //
    }

    /**
     * Handle the BookCopy "updated" event.
     *
     * @param  \App\Models\BookCopy  $bookCopy
     * @return void
     */
    public function updated(BookCopy $bookCopy)
    {
//    SET @COPY_ID := REGEXP_REPLACE(OLD.Id, '^[A-Za-z]+\/[0-9]+\/', '');
//    SET @BOOK_ID := REGEXP_REPLACE(OLD.Id, '\/[0-9]+$', '');
//    drop temporary table if exists `TEMP_49`;
//    create temporary table `TEMP_49` as (SELECT REGEXP_REPLACE(`Id`, '^[A-Za-z]+\/[0-9]+\/', '') as `Id` FROM `bookcopies` WHERE `BookId` = @BOOK_ID order by `Id`);
//    DELETE FROM `TEMP_49` WHERE `Id` = @COPY_ID limit 1;
//    SET @COUNT := (select count(*) from `TEMP_49`);
//    SET @I := 0;
//    loop_0: WHILE(@I < @COUNT)
//    DO
//        SET @CURRENT := (select `Id` from `TEMP_49` limit 1);
//        UPDATE `bookcopies` SET `Id` = (@BOOK_ID+'/'+(@I+1)) WHERE `Id` = (@BOOK_ID+'/'+@CURRENT);
//        DELETE FROM `TEMP_49` limit 1;
//        SET @I := @I + 1;
//    END WHILE;

    }

    /**
     * Handle the BookCopy "deleted" event.
     *
     * @param  \App\Models\BookCopy  $bookCopy
     * @return void
     */
    public function deleted(BookCopy $bookCopy)
    {
        DB::transaction(function() use ($bookCopy) {
            $keyname = (new BookCopy)->getKeyName();
            $bookId = $bookCopy->{Book::FOREIGN_KEY};
            $copies = BookCopy::where(Book::FOREIGN_KEY, $bookId)->get()->all();
            for($i = 0, $iMax = count($copies); $i < $iMax; $i++)
            {
                $newId = $bookId . "/" . ($i+1);
                if($copies[$i]->getKey() !== $newId) {
                    $copies[$i]->{$keyname} = $newId;
                    $copies[$i]->save();
                }
            }
            return true;
        });
    }

    /**
     * Handle the BookCopy "restored" event.
     *
     * @param  \App\Models\BookCopy  $bookCopy
     * @return void
     */
    public function restored(BookCopy $bookCopy)
    {
        //
    }

    /**
     * Handle the BookCopy "force deleted" event.
     *
     * @param  \App\Models\BookCopy  $bookCopy
     * @return void
     */
    public function forceDeleted(BookCopy $bookCopy)
    {
        //
    }
}
