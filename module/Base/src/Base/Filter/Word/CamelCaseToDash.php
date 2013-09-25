<?php 

namespace Base\Filter\Word;

class CamelCaseToDash extends \Zend\Filter\Word\CamelCaseToDash {
    
    /**
     * Currently there is a bug in the zend library and this class purpose is to fix that
     * @param string $value
     */
    
    public function filter($value) {
        
        $value = parent::filter($value);
        return strtolower((string) $value); // zend library doesn't lowercase so we have to do it       
    }    
}