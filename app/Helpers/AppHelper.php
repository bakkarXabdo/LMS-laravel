<?php


namespace App\Helpers;


class AppHelper
{
    public static function getSqlWithBindings($query)
    {
        $a1 = str_replace('?', '%s', $query->toSql());
        $a2 = collect($query->getBindings())->map(function ($binding) {
            return is_numeric($binding) ? $binding : "'{$binding}'";
        })->toArray();
        $s = $a1;
        $i = 0;
        while(($pos = strpos($s, "%s")) > 0)
        {
            $s = substr($s, 0, $pos) . $a2[$i] . substr($s, $pos+2);
            $i++;
        }
        return $s;
    }

    public static function ArabicFormat($text, $params): string
    {
        if(!is_array($params))
        {
            $params = [$params];
        }
        return vsprintf(str_replace('؟', '%s', $text), $params);
    }

    public static function dieWithMessage($message)
    {
        echo $message;
        exit;
    }
}