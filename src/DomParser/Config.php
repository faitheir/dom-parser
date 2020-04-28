<?php

namespace Faitheir\DomParser;

class Config
{
    static private $instance;

    private function __clone(){}
    # parser configs
    private $_config = [
        # parse
        'start_tag_reg'     => '/^\s*<([^>\s\/!]+)/is',
        'start_end_tag_reg' => '/(^\s*>)|(^\s*\/>)/is',
        'end_tag_reg'       => '/^\s*<([^>\s\/]+)/is',
        'content_reg'       => '/^\s*([^<]+)|(^\s*<!--((?!-->).)*-->)/is',
        'attrs_reg'         => '/^\s*([^=>< ]+)="([^"]*)"|\s([^=><\s]+)(?=\s|>)/iU',
        # inverse parse
        'tag_indent'        => '    ',
        'hide_genid'        => false,
    ];

    private function __construct($confs = [])
    {
        if (!empty($confs))
            $this->setConfig($confs);
    }
    static public function getInstance($confs = [])
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self($confs);
        }
        if (!empty($confs))
            self::$instance->setConfig($confs);

        return self::$instance;
    }

    /**
     * dynamic settings
     */
    public function setConfig($confs = [])
    {
        $this->_config = array_merge($this->_config, $confs);
    }

    /**
     * get config
     * @param string $key
     * @return array|mixed|string
     */
    public function get($key = '')
    {
        if (empty($key))
            return $this->_config;

        if (strpos($key, '.') === false)
            return $this->_config[$key] ?? '';

        return null;
    }
}