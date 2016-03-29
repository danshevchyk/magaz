<?php

class Lang {

    protected static $data;

    public static function load($lang_code){
        $land_life_path = ROOT.DS.'lang'.DS.strtolower($lang_code).'.php';

        if ( file_exists($land_life_path) ){
            self::$data = include($land_life_path);
        }else {
            throw new Exception('Языковой файл не найден: '.$land_life_path);
        }
    }

    public static function get($key, $default_value = ''){
        return isset(self::$data[strtolower($key)]) ? self::$data[strtolower($key)] : $default_value;
    }
}