<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * App\Models\Student
 *
 *
 * @property int $Id
 * @property int $UserId
 * @property string $Name
 * @property string $Speciality
 * @property string $BirthDate
 * @property int $TotalRentals
 * @property \Illuminate\Support\Carbon $RegisteredAt
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Rental[] $rentals
 * @property-read int|null $rentals_count
 * @property-read \App\Models\User $user
 * @method static Builder|Student newModelQuery()
 * @method static Builder|Student newQuery()
 * @method static Builder|Student query()
 * @method static Builder|Student whereBirthDate($value)
 * @method static Builder|Student whereId($value)
 * @method static Builder|Student whereName($value)
 * @method static Builder|Student whereRegisteredAt($value)
 * @method static Builder|Student whereSpeciality($value)
 * @method static Builder|Student whereTotalRentals($value)
 * @method static Builder|Student whereUserId($value)
 * @method static Builder|Student offset($value)
 * @method static Student first($columns = ['*'])
 *
 * @mixin Builder
 */
class Student extends Model
{
    use ModelTraits;

    public const TABLE = "students";
    public const KEY = "Id";
    public const TABLE_DOT_KEY = self::TABLE . "." . self::KEY;

    public const FOREIGN_KEY = "StudentId";
    public const CREATED_AT = "RegisteredAt";
    public const UPDATED_AT = null;

    protected $table = self::TABLE;
    protected $primaryKey = self::KEY;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $guarded = [];


    function rentals(){
        return $this->hasMany(Rental::class);
    }

    function rentalHistories()
    {
        return $this->hasMany(RentalHistory::class);
    }

    function user()
    {
        return $this->hasOne(User::class);
    }
}
