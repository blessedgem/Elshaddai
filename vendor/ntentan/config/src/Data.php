<?php

namespace ntentan\config;

class Data
{

    private $config;
    private $context = 'default';

    public function __construct($path = null)
    {
        if(is_dir($path)) {
            $dir = new Directory($path);
            $this->config = ['default' => $this->expand($dir->parse())];
            foreach ($dir->getContexts() as $context) {
                $this->config[$context] = array_merge(
                    $this->config['default'], $this->expand($dir->parse($context))
                );
            }
        } else if(is_file($path)) {
            $this->config[$this->context] = $this->expand(File::read($path));
        }
    }
    
    public function isKeySet($key)
    {
        return isset($this->config[$this->context][$key]);
    }

    public function get($key)
    {
        return $this->config[$this->context][$key];
    }

    public function setContext($context)
    {
        $this->context = $context;
    }

    public function set($key, $value)
    {
        $keys = explode('.', $key);
        $this->config[$this->context] = $this->setValue($keys, $value, $this->config[$this->context]);
        $this->config[$this->context][$key] = $value;
        if(is_array($value)) {
            $this->config[$this->context] += $this->expand($value, $key);
        }
    }
    
    private function setValue($keys, $value, $config)
    {
        if(!empty($keys)) {
            $key = array_shift($keys);
            $config[$key] = $this->setValue($keys, $value, $config[$key]);
            return $config;
        } else {
            return $value;
        }
    }

    private function expand($array, $prefix = null)
    {
        $config = [];
        if(is_array($array)) {
            $dot = $prefix ? "$prefix." : "";
            foreach($array as $key => $value) {
                $config[$dot.$key] = $value;
                $config += $this->expand($value, $dot.$key);
            }
            $config[$prefix] = $array;
        }
        return $config;
    }    
}
