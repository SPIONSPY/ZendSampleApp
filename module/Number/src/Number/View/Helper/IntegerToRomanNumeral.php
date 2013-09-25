<?php

namespace Number\View\Helper;

use Zend\View\Helper\AbstractHelper;

class IntegerToRomanNumeral extends AbstractHelper 
{
    /**
     * @var NumberConverter
     * TODO: create NumberConverter Interface
     */
    
    protected $numberConverter;

    public function __construct ($numberConverter) {
        
        $this->numberConverter = $numberConverter;
    }
    
    /**
     * Called upon invoke
     * Converts an integer to a roman numeral
     * @param integer $integer
     * @return string 
     */
    
    public function __invoke($integer) {
        
        return $this->numberConverter->integerToRomanNumeral($integer);
    }
}