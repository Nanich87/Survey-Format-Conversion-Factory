<?php

namespace Survey\Format\InputFormat;

class KPT_Format extends \Survey\Format\InputFormat\Base_Format {

    protected $inputFile;
    private $_data = [];
    private $_dataFormat;

    public function __construct($inputFileString, $outputFormat) {
        parent::__construct($inputFileString, $outputFormat);

        $this->inputFile = explode(PHP_EOL, $inputFileString);

        $this->_dataFormat = new \Survey\Data\Convert\KPT_Format();
    }

    public function convert() {
        $fileSize = count($this->inputFile);
        for ($i = 1; $i < $fileSize - 1; $i++) {
            $this->inputFile[$i] = preg_replace("/\s\s+/", ' ', trim($this->inputFile[$i]));
            $lineSize = count(explode(' ', $this->inputFile[$i]));
            switch ($lineSize) {
                case 5:
                    list($pointNumber, $x, $y, $height, $description) = sscanf($this->inputFile[$i], '%s %f %f %f %s');
                    $this->_data[] = array(
                        'point_number' => $pointNumber,
                        'x' => $x,
                        'y' => $y,
                        'height' => $height,
                        'description' => $description
                    );
                    break;
            }
        }
    }

    public function toArray() {
        return $this->_data;
    }

    public function toString() {
        $outputFileString = $this->getData($this->_data, $this->_dataFormat, $this->оutputFormat);

        return $outputFileString;
    }

}