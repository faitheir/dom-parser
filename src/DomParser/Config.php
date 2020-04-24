<?php

namespace Faitheir\DomParser;

class Config
{

    # parser configs
    private $_config = [
        'start_tag_reg'     => '/^\s*<([^>\s\/!]+)/is',
        'start_end_tag_reg' => '/(^\s*>)|(^\s*\/>)/is',
        'end_tag_reg'       => '/^\s*<([^>\s\/]+)/is',
        'content_reg'       => '/^\s*([^<]+)|(<!--.*-->)/is',
        'attrs_reg'         => '/^\s*([^=>< ]+)="([^"]*)"|\s([^=><\s]+)(?=\s|>)/iU',
    ];

    /**
     * Config constructor.
     * @param array $confs
     */
    public function __construct($confs = [])
    {
        if (!empty($confs))
            $this->setConfig($confs);
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