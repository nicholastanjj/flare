<?php

require_once '../classes/DB.php';

class Installer
{

    private static $_error;

    public static function showTemplate($name) 
    {

        if (file_exists('./templates/'.$name.'.php')) {
            include_once './templates/'.$name.'.php';
            return true;
        } else {
            return false;
        }

    }

    public static function createConfig($data = array()) 
    {

        $template = file_get_contents('./templates/config.php');
        foreach ($data as $name => $val) {
            $template = str_replace($name, $val, $template);
        }

        $file = fopen('../core/config.php', 'w');

        if (!$file) {
            self::$_error = true;
        }

        fwrite($file, $template);
        fclose($file);

        return true;

    }

    public static function appendConfig($data = array()) 
    {

        $currentConf = file_get_contents('../core/config.php');
        foreach ($data as $name => $val) {
            $currentConf = str_replace($name, $val, $currentConf);
        }

        $file = fopen('../core/config.php', 'w+');

        if (!$file) {
            self::$_error = true;
        }

        fwrite($file, $currentConf);
        fclose($file);

        return true;

    }   

    public static function setupDb()
    {

        $sql = file_get_contents('./install.sql');
        $db = DB::newInstance();

        if (!$db->query($sql)) {
            self::$_error = true;
            return false;
        }
        return true;

    }

    public static function error()
    {

        return self::$_error;

    }

}