<?php
use Carbon\Carbon;

if (!function_exists("create_upload_folder")) {
    function create_upload_folder(string $path, bool $addCurYearMonth = true, $isFullPath = false){
        $year = Carbon::now()->format("Y");
        $month = Carbon::now()->format("m");
        $uploadFolder = "uploads/{$path}/{$year}/{$month}";

        if(!$addCurYearMonth)
            $uploadFolder = "uploads/{$path}";

        $path = storage_path("app/public/{$uploadFolder}");
        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
        if($isFullPath)
            return $path;

        return $uploadFolder;
    }
}