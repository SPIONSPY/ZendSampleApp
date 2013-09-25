<?php 

namespace Base\Mvc\Router\Http;

use Traversable;
use Zend\Mvc\Router\Exception;
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\RequestInterface as Request;

/**
 * Route that always returns false
 * Used as the start point for modules
 *
 * @see        http://guides.rubyonrails.org/routing.html
 */

class Bad extends \Zend\Mvc\Router\Http\Segment
{

    /**
     * factory(): defined by RouteInterface interface.
     *
     * @see    Route::factory()
     * @param  array|Traversable $options
     * @throws \Zend\Mvc\Router\Exception\InvalidArgumentException
     * @return Segment
     */
    public static function factory($options = array())
    {
        if ($options instanceof Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        } elseif (!is_array($options)) {
            throw new Exception\InvalidArgumentException(__METHOD__ . ' expects an array or Traversable set of options');
        }
    
        $options['route'] = '';

        $options['constraints'] = array(
            'bad' => 'bad',
        );
        
        if (!isset($options['defaults'])) {
            $options['defaults'] = array();
        }
    
        return new static($options['route'], $options['constraints'], $options['defaults']);
    } 
}