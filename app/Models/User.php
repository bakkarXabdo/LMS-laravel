<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\User
 *
 * @mixin Builder
 * @property int $Id
 * @property int $IsAdmin
 * @property string Name
 * @property string $username
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon $CreatedAt
 * @property \Illuminate\Support\Carbon $UpdatedAt
 * @property-read mixed $is_admin
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereIsAdmin($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUsername($value)
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, ModelTraits;

    public const TABLE = "users";
    public const KEY = "Id";
    public const TABLE_DOT_KEY = self::TABLE . "." . self::KEY;

    public const FOREIGN_KEY = "UserId";
    public const CREATED_AT = "CreatedAt";
    public const UPDATED_AT = "UpdatedAt";

    protected $table = self::TABLE;
    protected $primaryKey = self::KEY;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Name',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];



    public function getIsAdminAttribute()
    {
        return (bool)$this->attributes["IsAdmin"];
    }

    public function student()
    {
        return $this->HasOne(Student::class);
    }



}
