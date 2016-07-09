<?php
$config['PhpThumb']['thumbs_path'] = 'files/thumbs';
$config['PhpThumb']['q'] = 90;
$config['PhpThumb']['disable_debug'] = false;

class CONSTANTS {
    const SITEURL = 'http://dev.josephdeming.net/cake';
}

class CACHEDBS {
    static $COMMON = 0;
    static $SEARCH = 1;
    static $FILES = 2;
    static $MARKDOWN = 3;
}

class APIBASE {
    const PHOTOS = '/api/photos';
    const MUSICCOMPLETE = '/api/music/complete';
    const TV = '/api/tv';
}

class URLBASE {
    const PHOTOS = CONSTANTS::SITEURL . APIBASE::PHOTOS;
    const MUSICCOMPLETE = CONSTANTS::SITEURL . APIBASE::MUSICCOMPLETE;
    const TV = CONSTANTS::SITEURL . APIBASE::TV;
}

class PATHBASE {
    const PHOTOS = '/net/council/home/www/dev/cake/api/media/pics/PERSONAL';
    const MUSICCOMPLETE = '/net/council/home/www/dev/cake/api/media/music/tagged_complete';
    const TV = '/net/council/home/www/dev/cake/api/media/tv';
}

