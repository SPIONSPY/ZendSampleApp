<?php

namespace ShopTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class ProductControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(
            include dirname(__FILE__) . '/../../../../../config/application.config.php'
        );
        parent::setUp();
    }
    
    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/shop/product');
        $this->assertResponseStatusCode(200);
    
        $this->assertModuleName('Shop');
        $this->assertControllerName('Shop\Controller\ProductController');
        $this->assertControllerClass('ProductController');
        $this->assertMatchedRouteName('shop/product');
    }    
}