<?php

class FileService {

    public static function ReadFiles($base_path, $base_url, $sort_func = null, $filter = null) {
        // open this directory
        $tarDirectory = opendir($base_path);

        $retArray = [];
        // get each entry
        while($entryName = readdir($tarDirectory)) {
            if (!preg_match('/^\./', $entryName) && (!$filter || preg_match($filter, $entryName))) {
                    $full_path = "$base_url/$entryName";
                    $file_size = is_dir("$base_path/$entryName") ? 0 : filesize("$base_path/$entryName");
                    $retArray[] = ['name' => $entryName, 'uri' => $full_path, 'size' => $file_size ];
            }
        }

        // close directory
        closedir($tarDirectory);

        // sort 'em
        if ($sort_func) {
            usort($retArray, $sort_func);
        }

        return($retArray);
    }

    public static function RReadFiles($base_path, $rel_path, $sort = "self::AlphaAsc") {
        $files = self::ReadFiles($base_path, $rel_path, $sort);

        foreach($files as $file) {
            if (is_dir("$base_path/${file['name']}")) {
                $files = array_merge($files, self::RReadFiles("$base_path/${file['name']}", "$rel_path/${file['name']}", $sort));
            }
        }

        return $files;
    }

    public static function FileInfo($path) {
        $fileinfo = null;
        if (file_exists($path)) {
            $fileinfo = pathinfo($path);
            $fileinfo['path'] = $path;
            $fileinfo['isdir'] = is_dir($path);
            $fileinfo['size'] = $fileinfo['isdir'] ? 0 : filesize($path);
        }
        return $fileinfo;
    }

    private static function AlphaAsc($r, $l) {
            return strcmp($r['name'], $l['name']);
    }

    private static function SizeAsc($r, $l) {
            return strcmp($r['size'], $l['size']);
    }
}
