<?php
namespace ntentan\config;

class File
{
    public static function read($file)
    {
        return require $file;
    }
}
