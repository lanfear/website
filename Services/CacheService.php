<?php

App::import('Services', 'CacheService');

class CacheService {

    private $fullpath_tv = "/net/council/home/www/dev/cake/api/media/tv";

  	private static function GetCacheProvider($db_num) {
        $r = new Redis();
        $r->connect('127.0.0.1', 9379);
        $r->select($db_num);
		return $r;
	}

    public static function CacheTv() {
        $relative_tv = "/api/tv";

        $tv_paths = $this->RReadFiles($this->fullpath_tv, $relative_tv);
		$cache_search = $this->GetCacheProvider(CACHEDBS::$SEARCH);
		$cache_files = $this->GetCacheProvider(CACHEDBS::$FILES);
		foreach($tv_paths as $tv_path) {
			$rel_path = preg_replace("/\/api\/tv\//", "", $tv_path['uri']);
			$path_parts = preg_replace("/\..*$/", "", $rel_path);
			$path_parts = preg_split('/\/| - /', $path_parts);
			$key = $this->GetCacheKey('tv', $tv_path['uri'], $tv_path['name']);
			$cache_search->set(strtolower(implode(' ', $path_parts)), $key);
			$cache_files->set($key, "{$this->fullpath_tv}/$rel_path");
		}
    }

    public static function CacheTv() {
        $relative_tv = "/api/tv";

        $tv_paths = $this->RReadFiles($this->fullpath_tv, $relative_tv);
		$cache_search = $this->GetCacheProvider(CACHEDBS::$SEARCH);
		$cache_files = $this->GetCacheProvider(CACHEDBS::$FILES);
		foreach($tv_paths as $tv_path) {
			$rel_path = preg_replace("/\/api\/tv\//", "", $tv_path['uri']);
			$path_parts = preg_replace("/\..*$/", "", $rel_path);
			$path_parts = preg_split('/\/| - /', $path_parts);
			$key = $this->GetCacheKey('tv', $tv_path['uri'], $tv_path['name']);
			$cache_search->set(strtolower(implode(' ', $path_parts)), $key);
			$cache_files->set($key, "{$this->fullpath_tv}/$rel_path");
		}
    }

    public static function Search($keyword) {
		$cache_search = self::GetCacheProvider(CACHEDBS::$SEARCH);
		$matches = $cache_search->keys('*' . strtolower($keyword) . '*');
		if (sizeof($matches) > 0) {
			$cache_files = self::GetCacheProvider(CACHEDBS::$FILES);
			return $cache_files->mGet($cache_search->mGet($matches));
		} else {
		    return array();
		}
    }

}
