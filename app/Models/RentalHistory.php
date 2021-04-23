<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RentalHistory
 *
 * @property int $Id
 * @property string $StudentId
 * @property string $CustomerName
 * @property string $BookId
 * @property string $BookTitle
 * @property string $RentalCreatedAt
 * @property string $RentalExpiresAt
 * @property \Illuminate\Support\Carbon $RentalReturnedAt
 * @method static \Illuminate\Database\Eloquent\Builder|RentalHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RentalHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RentalHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|RentalHistory whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RentalHistory whereBookTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RentalHistory whereCustomerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RentalHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RentalHistory whereRentalCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RentalHistory whereRentalExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RentalHistory whereRentalReturnedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RentalHistory whereStudentId($value)
 * @mixin \Eloquent
 */
class RentalHistory extends Model
{
    use ModelTraits;

    public const TABLE = "rentals_history";
    public const KEY = "Id";
    public const TABLE_DOT_KEY = self::TABLE . "." . self::KEY;

    public const FOREIGN_KEY = "RentalHistoryId";
    public const CREATED_AT = "RentalReturnedAt";
    public const UPDATED_AT = null;

    protected $table = self::TABLE;
    protected $primaryKey = self::KEY;
    protected $guarded = [];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    // Nullable
    public function copy()
    {
        return $this->belongsTo(BookCopy::class);
    }
    // Nullable
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
