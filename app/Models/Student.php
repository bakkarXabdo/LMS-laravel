<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * App\Models\Student
 *
 * @mixin Builder
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
 */
class Student extends Model
{
    use HasFactory;

    public const TABLE = "students";
    public const KEY = "Id";
    public const FOREIGN_KEY = "StudentId";
    public const CREATED_AT = "RegisteredAt";
    public const UPDATED_AT = null;

    protected $table = self::TABLE;
    protected $primaryKey = self::KEY;
    protected $guarded = [];


    function rentals(){
        return $this->hasMany(Rental::class, self::FOREIGN_KEY, self::KEY);
    }

    function user()
    {
        return $this->belongsTo(User::class, User::FOREIGN_KEY, User::KEY);
    }

    public static function joinWithSelf(Builder $query,Model $with) : Builder
    {
        return $query->join(self::TABLE, $with::TABLE . "." . self::FOREIGN_KEY, '=', self::TABLE . "." . self::KEY);
    }
}
