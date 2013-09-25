<?php

namespace Number\View\Helper;

use Zend\View\Helper\AbstractHelper;

class RomanNumeralToInteger extends AbstractHelper 
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
     * Converts the a roman numeral to an integer
     * @param integer $integer
     * @return string 
     */
    
    public function __invoke($integer) {
        
        return $this->numberConverter->romanNumeralToInteger($integer);
    }
}