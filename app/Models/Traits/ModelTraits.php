<?php

namespace App\Models\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait ModelTraits
{

    public function getCreatedAttribute()
    {
        return Carbon::parse($this->attributes[$this->getCreatedAtColumn()]);
    }

    public function getForeignKey()
    {
        return $this::FOREIGN_KEY;
    }

    public static function joinWithSelf(Builder $query) : Builder
    {
        $with = $query->getModel();
        return $query->join(self::TABLE, $with::TABLE . "." . self::FOREIGN_KEY, '=', self::TABLE . "." . self::KEY);
    }

    public function belongsTo($related, $foreignKey = null, $ownerKey = null, $relation = null)
    {
        if (is_null($relation)) {
            $relation = $this->guessBelongsToRelation();
        }

        $instance = $this->newRelatedInstance($related);
        if (is_null($foreignKey)) {
            $foreignKey = $instance->getForeignKey();
        }
        $ownerKey = $ownerKey ?: $instance->getKeyName();

        return $this->newBelongsTo(
            $instance->newQuery(), $this, $foreignKey, $ownerKey, $relation
        );
    }

    public static function urlname()
    {
        return strtolower(class_basename(self::class));
    }
}
