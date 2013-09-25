<?php

namespace Number;

class Number {
    
    /**
     * Value of the number in integer format
     * @var integer
     */
    
    protected $value;

    /**
     * Possible formats for the value when constructing the number
     */
    
    const INTEGER = 0;
    const ROMAN_NUMERAL = 1;
    
    /**
     * Construct the number
     * @param string $value Value of the number
     * @param string $format Format of the number
     */
    
     public function __construct($value, $format = null) {

        if (is_null($format)) $format = self::INTEGER; // default format

        switch ($format) {
            
            case (self::INTEGER): 
                $this->value = (int) $value; 
                break;
            case (self::ROMAN_NUMERAL): 
                $this->value = $this->convertRomanNumeralToInteger($value); 
                break;
            default: 
                $this->value = (int) $value;
        }
    }
    
    /**
     * Returns the integer value of this number
     * @return integer
     */
    
    public function toInteger() {
        
        return $this->value;
    }
    
    /**
     * Returns the roman numeral representation of this number
     * @return string
     */
    
    public function toRomanNumeral() {

        return $this->convertIntegerToRomanNumeral($this->value); // TODO: cache this operation
    }

    /**
     * Converts a positive value of a 32-bit signed integer to a roman numeral
     * @param integer $number
     * @return boolean|string
     */
    
    protected function convertIntegerToRomanNumeral($number) {
        
        if (!is_int($number) || $number < 1) return false; // ignore negative numbers and zero
        
        $integers = array(900, 500,  400, 100,   90,  50,   40,  10,    9,   5,    4,   1);
        $numerals = array('CM', 'D', 'CD', 'C', 'XC', 'L', 'XL', 'X', 'IX', 'V', 'IV', 'I');
        $major = intval($number / 1000) * 1000;
        $minor = $number - $major;
        $numeral = $leastSig = '';
        
        for ($i = 0; $i < sizeof($integers); $i++) {
            while ($minor >= $integers[$i]) {
                $leastSig .= $numerals[$i];
                $minor  -= $integers[$i];
            }
        }
        
        if ($number >= 1000 && $number < 40000) {
            if ($major >= 10000) {
                $numeral .= '(';
                while ($major >= 10000) {
                    $numeral .= 'X';
                    $major -= 10000;
                }
                $numeral .= ')';
            }
            if ($major == 9000) {
                $numeral .= 'M(X)';
                return $numeral . $leastSig;
            }
            if ($major == 4000) {
                $numeral .= 'M(V)';
                return $numeral . $leastSig;
            }
            if ($major >= 5000) {
                $numeral .= '(V)';
                $major -= 5000;
            }
            while ($major >= 1000) {
                $numeral .= 'M';
                $major -= 1000;
            }
        }
        
        if ($number >= 40000) {
            $major = $major/1000;
            $numeral .= '(' . convertIntegerToRomanNumeral($major) . ')';
        }
        
        return $numeral . $leastSig;
    }

    /**
     * Roman numeral values converted to decimals
     * @var array
     */
    
    protected $romanNumeralsToDecimals = array(
        'I' => 1,
        'V' => 5,
        'X' => 10,
        'L' => 50,
        'C' => 100,
        'D' => 500,
        'M' => 1000,        
    );
    
    /**
     * Converts a roman numeral to integer
     * @param string $romanNumeral
     * @return integer
     */
    
    protected function convertRomanNumeralToInteger($romanNumeral) {

        // breaks the string into an array of chars
        
        $digits = str_split($romanNumeral);
        $lastIndex = count($digits)-1;
        $sum = 0;
        
        foreach($digits as $index => $digit)
        {
            if(!isset($digits[$index]))
            {
                continue;
            }
        
            if(isset($this->romanNumeralsToDecimals[$digit]))
            {
                if($index < $lastIndex)
                {
                    $left = $this->romanNumeralsToDecimals[$digits[$index]];
                    $right = $this->romanNumeralsToDecimals[$digits[$index+1]];
                    if($left < $right)
                    {
                        $sum += ($right - $left);
                        unset($digits[$index+1],$left, $right);
                        continue;
                    }
                    unset($left, $right);
                }
            }
            $sum += $this->romanNumeralsToDecimals[$digit];
        }
        
        return $sum;        
    }
}