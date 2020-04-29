<?php
/**
 * Created by PhpStorm.
 * User: WangFei
 * Date: 4/22/2020
 * Time: 3:41 PM
 */

namespace Faitheir\DomParser;


class Tools
{
    static private $instance;

    private function __construct(){}
    private function __clone(){}

    static public function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     *
     * @return string
     */
    public function nodeId()
    {
        static $number = 0;
        if (!$number)
            $number = time();

        return 'genid-' . ++ $number;
    }

    /**
     * @param $delimiter
     * @param $string
     */
    public function stringToArray($delimiter, $string)
    {
        if (empty(trim($string)))
            return [];

        $values = array_filter(explode($delimiter, $string), function ($item) {
            return strlen($item) > 0;
        });
        return (array) $values;
    }
}