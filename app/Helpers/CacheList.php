<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class CacheList
{
    /**
     * @param string $listName
     * @param mixed $item
     * @param Illuminate\Support\Carbon $timestamp
     * @return bool
     */
    public static function store($listName, $item, $timestamp = null)
    {
        return self::add($listName, $listName.$item, $item, $timestamp);
    }
    /**
     * @param string $listName
     * @param mixed $item
     * @param Illuminate\Support\Carbon $timestamp
     * @return bool
     */
    public static function add($listName, $itemName, $item, $timestamp = null)
    {
        if(!empty($item))
        {
            $names = Cache::get($listName) ?? [];
            if(!in_array($itemName, $names, true))
            {
                Cache::put($itemName, $item, $timestamp ?? now()->addMonths(3));
                $names[] = $itemName;
                Cache::put($listName, $names);
                return true;
            }
        }
        return false;
    }
    /**
     * @param string $listName
     * @param mixed $item
     * @param Illuminate\Support\Carbon $timestamp
     * @return bool
     */
    public static function addName($listName, $name)
    {
        $names = Cache::get($listName) ?? [];
        $names[] = $name;
        Cache::put($listName, $names);
    }
    /**
     * @param string $listName
     * @return Illuminate\Support\Collection
     */
    public static function getList($listName)
    {
        $names = Cache::get($listName) ?? [];
        $stored = [];
        foreach($names as $name)
        {
            $v = Cache::get($name);
            if(!empty($v))
            {
                $stored[] = $v;
            }
        }
        return collect($stored);
    }
    /**
     * @param string $listName
     * @param string $value
     * @return bool
     */
    public static function has($listName, $value)
    {
        if(empty($value))
        {
            return false;
        }
        $names = Cache::get($listName) ?? [];
        foreach($names as $name)
        {
            if(Cache::get($name) === $value)
            {
                return true;
            }
        }
        return false;
    }
    /**
     * @param string $listName
     * @return void
     */
    public static function forgetList($listName)
    {
        $names = Cache::get($listName) ?? [];
        foreach($names as $name)
        {
            Cache::forget($name);
        }
        Cache::forget($listName);
    }
}
