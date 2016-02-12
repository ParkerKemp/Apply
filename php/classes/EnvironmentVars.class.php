<?php

class EnvironmentVars {
    private static $dbName;
    private static $sockPath;
    
    public static function getSocketPath(){
        return static::$sockPath;
    }
    
    public static function getDatabaseName(){
        return static::$dbName;
    }
    
    public static function load(){
        $config = parse_ini_file('../config/config.ini');
        static::$dbName = $config['dbName'];
        static::$sockPath = $config['socketPath'];
    }
}

EnvironmentVars::load();
