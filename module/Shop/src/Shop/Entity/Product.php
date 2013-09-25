<?php

namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * @ORM\Entity(repositoryClass="ProductRepository")
 * @ORM\Table(name="product")
 */

class Product implements InputFilterAwareInterface {

    public function __construct() {
        
    }
    
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    
    protected $id;

    public function getId() {
    
        return $this->id;
    }
    
    /** 
     * @ORM\Column(type="string", length=100, nullable=false, unique=true) 
     */
    
    protected $slug;

    public function getSlug() {
    
        return $this->slug;
    }
    
    public function setSlug($slug) {
    
        $this->slug = $slug;
    }
    
    /** 
     * @ORM\Column(type="string", length=100, nullable=false) 
     */
    
    protected $title;

    public function getTitle() {
    
        return $this->title;
    }
    
    public function setTitle($title) {
    
        $this->title = $title;
    }

    /**
     * Method used by form
     * @param unknown $data
     */
    
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->slug = (isset($data['slug'])) ? $data['slug'] : null;
        $this->title  = (isset($data['title'])) ? $data['title'] : null;
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
    /**
     * Validation
     * @var InputFilterInterface
     */
    
    protected $inputFilter;
    
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            	
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();
    
            $inputFilter->add($factory->createInput(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));
    
            $inputFilter->add($factory->createInput(array(
                'name'     => 'slug',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));
    
            $inputFilter->add($factory->createInput(array(
                'name'     => 'title',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));
       
            $this->inputFilter = $inputFilter;
        }
    
        return $this->inputFilter;
    }    
}