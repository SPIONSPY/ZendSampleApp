<?php

namespace Shop\Service;

use Base\Debug\Debug;
use Doctrine\Common\Persistence\ObjectManager;

use Shop\Entity\Product;

class ShopManager {

    /**
     * @var Array
     */
    
    protected $params;
    
    /**
     * @var ObjectManager
     */
    
    protected $objectManager;    
        
    /**
     * Set the Module specific configuration parameters
     *
     * @param Array $params
     * @param ObjectManager $objectManager
     */
    
    public function __construct($params, ObjectManager $objectManager) {
        
        $this->params = $params;
        $this->objectManager = $objectManager;
    }

    /**
     * Get all products
     * 
     * @return Product[]
     */
    
    public function findProducts() {

        $productRepo = $this->objectManager->getRepository(Product::class);
        $products = $productRepo->findAll();
        
        return $products;
    }
    
    /**
     * Get product by id
     *
     * @param integer $id
     * @return Product
     */
    
    public function findProduct($id) {
    
        if (empty($id)) return null;
    
        $productRepo = $this->objectManager->getRepository(Product::class);
        $product = $productRepo->find($id);
    
        return $product;
    }
    
    /**
     * Get product by slug
     *
     * @param string $slug
     * @return Product
     */
    
    public function findProductBySlug($slug) {
    
        if (empty($slug)) return null;
    
        $productRepo = $this->objectManager->getRepository(Product::class);
        $product = $productRepo->findOneBy(['slug' => $slug]);
    
        return $product;
    }

    /**
     * Save product to database
     * @param Product $product
     */
    
    public function saveProduct(Product $product) {
        
        $this->objectManager->persist($product); // $product is now "managed"
        $this->objectManager->flush(); // commit changes to db        
    }
    
    /**
     * Remove product from the database
     * @param Product $product
     */
    
    public function removeProduct(Product $product) {
    
        $this->objectManager->remove($product);
        $this->objectManager->flush(); // commit changes to db
    }
    
}