<?php
namespace NumberTest\Service;

use PHPUnit_Framework_TestCase AS TestCase;

use Number\Service\NumberConverter;

class NumberConverterTest extends TestCase
{
    protected $integersToRomanNumerals = array(
        1990 => 'MCMXC',
        311 => 'CCCXI',
        1533 => 'MDXXXIII',
        2003 => 'MMIII',
        132 => 'CXXXII',
    );
    
    public function testIntegerToRomanNumeral()
    {
        $numberConverter = new NumberConverter();

        foreach ($this->integersToRomanNumerals as $integer => $romanNumeral) {
            
            $this->assertEquals($romanNumeral, $numberConverter->integerToRomanNumeral($integer));
        }
    }
    
    public function testRomanNumeralToInteger()
    {
        $numberConverter = new NumberConverter();

        foreach ($this->integersToRomanNumerals as $integer => $romanNumeral) {
        
            $this->assertEquals($integer, $numberConverter->romanNumeralToInteger($romanNumeral));
        }    
    }
    
}