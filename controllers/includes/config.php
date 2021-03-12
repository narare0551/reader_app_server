<?php
class init_Config
{
    public $title = 'NOBIS3 FacnrollERP';
    public $sub_title = 'NOBIS3 FacnrollERP';
    public $base_URL;
    public $root_path;
    public $error_message = 'on';

    public $host = '192.168.0.52';
    public $userid = 'nobis3';
    public $password = 'nobis31!';
    public $dbname = 'bluetooth';


    function __construct()
    {
//        $base_URL = ($_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
        $this->base_URL = ($_SERVER['SERVER_PORT'] != '80') ? $_SERVER['HTTP_HOST'] . ':' . $_SERVER['SERVER_PORT'] : $_SERVER['HTTP_HOST'];
        $this->root_path = $this->base_URL;


    }

}
class Theme_Config
{
    public static $menu_name = "";
    public static $content_bg_color = '#33373c';
    public static $menu_bg_color = '#33373c';
    public static $top_bg_color = '#33373c';
    public static $btn_bg_color = '#33373c';
    public static function Theme_Default()
    {
        self::$content_bg_color = '#33373c';
        self::$menu_bg_color = '#1d2436';
        self::$top_bg_color = '##ffffff';
        self::$btn_bg_color = '#67b8c7';
    }
}

