<?php

namespace App;

class Jobs
{

    public static function __callStatic($name, $arguments)
    {
        info("attempting to run job $name");
        $name(...$arguments);
    }

    public static function run()
    {
        if(random_int(0, 100) > 90){
            self::clearExcelCache();
        }
    }

    public static function clearExcelCache()
    {
        $jonName = __FUNCTION__;
        try{
            if(!cache()->has($jonName))
            {
                info("initilizing ".$jonName);
                cache()->put($jonName, now());
                return;
            }
            $now = now();
            $lastRun = cache()->get($jonName, now());
            $diff = $now->diffInDays($lastRun);
            if ($diff > 30) {
                info("Running $jonName");
                $directory = config('excel.temporary_files.local_path', storage_path().'\framework\laravel-excel');
                foreach (array_diff(scandir($directory), array('..', '.')) as $tmp) {
                    try {
                        unlink($tmp);
                    } catch (\Throwable $e) {}
                }
            }else{
                info("no need to run $jonName as diff is $diff");
            }

        }catch(\Throwable $ee){}
    }
}
