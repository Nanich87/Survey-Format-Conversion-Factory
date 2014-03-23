<?php

namespace Survey\Format\InputFormat;

abstract class Base_Format {

    const DEFAULT_OUTPUT_FORMAT = 'XML';

    protected $inputFile = null;
    protected $оutputFormat = null;
    private $_supportedOutputFormats = array(
        'XML' => 'eXtensible Markup Language',
        'TXT' => 'Text File',
        'JSON' => 'JavaScript Object Notation',
        'KML' => 'Keyhole Markup Language'
    );

    public function __construct($inputFileString, $outputFormat = DEFAULT_OUTPUT_FORMAT)
    {
        if (strlen($inputFileString) == 0)
        {
            throw new \Exception('Input file cannot be empty!');
        }
        $this->inputFile = $inputFileString;
        $this->setOutputFormat($outputFormat);
    }

    public function setOutputFormat($outputFormat = DEFAULT_OUTPUT_FORMAT)
    {
        if (isset($this->_supportedOutputFormats[$outputFormat]))
        {
            $this->оutputFormat = $outputFormat;
        }
        else
        {
            throw new \Exception('Invalid output format!');
        }
    }

    public static function getSupportedOutputFormats()
    {
        return $this->_supportedOutputFormats;
    }

    protected function getData($outputData, $outputType, $outputFormat = DEFAULT_OUTPUT_FORMAT)
    {
        $outputFileString = \Patterns\Factory\OutputFormatFactory::create($outputData, $outputType, $outputFormat);
        return $outputFileString->getData();
    }

    abstract function toArray();

    abstract function toString();
}