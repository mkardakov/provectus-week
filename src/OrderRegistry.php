<?php
/**
 * Created by PhpStorm.
 * User: mkardakov
 * Date: 6/27/18
 * Time: 1:29 PM
 */

namespace Pizza;

/**
 * Class OrderRegistry
 * @package Pizza
 */
class OrderRegistry
{

    /**
     * @var array
     */
    private static $collection = [];

    /**
     * @param $key
     * @param $value
     */
    public static function set($key, $value)
    {
        self::$collection[$key] = $value;
    }

    /**
     * @param $key
     * @return bool
     */
    public static function has($key)
    {
        return array_key_exists($key, self::$collection);
    }

    /**
     * @param $key
     * @return mixed
     * @throws \Exception
     */
    public static function get($key)
    {
        if (!self::has($key)) {
            throw new \Exception("No key with '$key' value in Registry map");
        }
        return self::$collection[$key];
    }
}