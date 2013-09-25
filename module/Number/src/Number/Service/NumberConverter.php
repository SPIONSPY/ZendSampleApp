<?php

namespace Number\Service;

use Number\Number;

class NumberConverter {

    /**
     * Convert integer to roman numeral
     * 
     * @param integer $number
     * @return string
     */
    
    public function integerToRomanNumeral($integer) {

        $number = new Number($integer,Number::INTEGER);
        return $number->toRomanNumeral();        
    }
    
    /**
     * Convert roman numeral to number
     *
     * @param string $romanNumber
     * @return integer
     */
    
    public function romanNumeralToInteger($romanNumeral) {

        $number = new Number($romanNumeral,Number::ROMAN_NUMERAL);
        return $number->toInteger();        
    }    
}