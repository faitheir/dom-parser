<?php

/**
 * DomParser Index File
 */
namespace Faitheir\DomParser;


class DomParser
{
    # the origin dom string
    private $orgDomString = '';

    # config object
    public $config;
    # parser object
    public $parser;


    /**
     * DomParser constructor.
     * @param string $domString
     * @param array $config
     */
    public function __construct($domString = '', $config = [])
    {
        $this->config = new Config($config);
        $this->parser = new Parser();

        if ($domString)
            $this->orgDomString = $domString;
    }

    /**
     * @return Config
     */
    public function setConfig($confs = [])
    {
        $this->config->setConfig($confs);
        return $this;
    }

    /**
     * the main method
     * @param string $domString
     * @return array
     */
    public function parse($domString = '')
    {
        if ($domString)
            $this->orgDomString = $domString;

        return $this->parser->config($this->config)->parse($this->orgDomString);
    }

}