<?php

namespace ntentan\config;

class Config
{
    /**
     *
     * @var Data
     */
    protected static $data;
    
    public static function init($path)
    {
        static::$data = new Data($path);
    }
    
    /**
     * 
     * @return Data
     */
    private static function getData()
    {
        if(!static::$data) {
            static::$data = new Data();
        }
        return static::$data;
    }
    
    public static function get($key, $default = null)
    {
        return static::getData()->isKeySet($key) ? static::$data->get($key) : $default;
    }
    
    public static function set($key, $value)
    {
        return static::getData()->set($key, $value);
    }
    
    public static function setContext($context)
    {
        static::$data->setContext($context);
    }
    
    public static function reset()
    {
        static::$data = null;
    }    
}
