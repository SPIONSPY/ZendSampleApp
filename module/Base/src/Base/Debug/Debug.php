<?php 

namespace Base\Debug;

use Zend\Debug\Debug as ZendDebug;
use Doctrine\Common\Util\Debug as DoctrineDebug;

class Debug extends ZendDebug {
    
    public static function doctrineDump($var, $label=null, $echo=true) {

        $maxDepth = 4;
        $var = DoctrineDebug::export($var,$maxDepth);
        
        return self::dump($var,$label,$echo);
    }
}