<?php


namespace App\Helpers;


use Illuminate\Support\Collection;

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

    public static function binarySearch(Collection $arr, int $left, int $right, $search, $key)
    {
        if ($right >= $left)
        {
            $mid = (int)($left + ($right - $left)/2);
            if ($arr[$mid][$key] === $search)
            {
                return $mid;
            }
            if ($arr[$mid][$key] > $search)
            {
                return self::binarySearch($arr, $left, $mid-1, $search, $key);
            }
            return self::binarySearch($arr, $mid+1, $right, $search, $key);
        }
        return -1;
    }

    public static function paginateCollection($collection, $perPage, $pageName = 'page', $fragment = null)
    {
        $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage($pageName);
        $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage);
        parse_str(request()->getQueryString(), $query);
        unset($query[$pageName]);
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentPageItems,
            $collection->count(),
            $perPage,
            $currentPage,
            [
                'pageName' => $pageName,
                'path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath(),
                'query' => $query,
                'fragment' => $fragment
            ]
        );
        return $paginator;
    }

    public static function DownloadFile($file, $exit=true) { // $file = include path
        if(file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='. basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            if($exit)
            {
                exit;
            }
        }
    }
}
