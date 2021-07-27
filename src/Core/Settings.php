<?php

namespace Schedule\Core;

class Settings
{
    // Settings storage
    static private $keys = array();

    /**
     * Get a setting value by key
     * Throw an error if key not found
     *
     * @param  mixed $key
     * @return mixed
     */
    static public function get($key) 
    {
        if(!self::isExist($key)) {
            throw new \Exception( "Error! '$key' not defined in Settings" );
        }
        return self::$keys[$key];
    }

    /**
     * Set into a settings array value by key
     * Throw an error if key not found
     *
     * @param mixed $key
     * @param mixed $value
     * @return mixed
     */
    static public function set($key, $value) 
    {
        self::$keys[$key] = $value;
    }

    /**
     * Check if value by the key is exist in settings 
     *
     * @param  mixed $key
     * @return boolean
     */
    static public function isExist($key) : bool
    {
        return isset(self::$keys[$key]);
    }
}