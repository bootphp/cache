<?php
/**
 * Created by IntelliJ IDEA.
 * User: LT
 * Date: 25/06/17
 * Time: 2:28 AM
 */

namespace bootphp\cache {

    class HardCache implements \Psr\SimpleCache\CacheInterface
    {
        public static $BUILD_PATH = "./build";
        public static $cache = null;
        public $prefix;
        public $hard;
        public $hard_file;
        public static $cache_array = array();
        public $dirty = false;
        public $name = "GLOBAL";

        public static function configure()
        {
            self::setBuildPath("./build");
            echo __FILE__;
        }

        public static function setBuildPath($BUILD_PATH)
        {
            self::$BUILD_PATH = $BUILD_PATH;
        }

        public function __construct($prefix = "GLOBAL", $hard_array = array())
        {
            $this->name = $prefix;
            $this->hard_file = self::$BUILD_PATH . 'rc_' . PROJECT_ID . "_" . $prefix . '.php';
            if ($this->exists()) {
                if (!isset (self::$cache_array [$this->name])) {
                    self::$cache_array [$this->name] = include $this->hard_file;
                }
            } else {
                self::$cache_array [$this->name] = $hard_array;
                $this->dirty = true;
            }
        }

        public function set($key, $value, $ttl = null)
        {
            self::$cache_array [$this->name] [$key] = $value;
            $this->dirty = true;
        }

        public function get($key, $default = null)
        {
            if ($this->has($key)) {
                return self::$cache_array [$this->name] [$key];
            } else {
                $this->set($key, $default);
                return $default;
            }
        }

        public function has($key)
        {
            return isset (self::$cache_array [$this->name] [$key]);
        }


        public function delete($key)
        {
            $array = self::$cache_array [$this->name];
            if ($this->has($key)) {
                unset($array);
            }
        }

        public function save($check = false)
        {
            if (!$check || $this->dirty) {
                file_put_contents(\bootphp\file::path($this->hard_file), '<?php return ' . var_export(self::$cache_array [$this->name], true) . ';');
            }
        }

        public function merge($cache_array)
        {
            self::$cache_array [$this->name] = array_merge(self::$cache_array [$this->name], $cache_array);
        }

        public function getArray()
        {
            return self::$cache_array [$this->name];
        }

        public function exists()
        {
            return file_exists($this->hard_file);
        }

        public function clear()
        {
            if ($this->exists()) {
                unlink($this->hard_file);
                self::$cache_array [$this->name] = null;
            }
        }

        public function getMultiple($keys, $default = null)
        {
            // TODO: Implement getMultiple() method.
        }

        public function setMultiple($values, $ttl = null)
        {
            // TODO: Implement setMultiple() method.
        }

        public function deleteMultiple($keys)
        {
            // TODO: Implement deleteMultiple() method.
        }

    }

}

