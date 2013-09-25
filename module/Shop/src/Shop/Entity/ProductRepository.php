<?php

namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;

use Doctrine\Common\Persistence\ObjectRepository;

class ProductRepository extends EntityRepository {

    /**
     * Get products
     * @return Product[]
     */
    
    public function findAll() {
        
        $dql = "
            SELECT Product 
            FROM " . Product::class . " Product
            ORDER BY Product.title ASC
        ";
        
        $query = $this->getEntityManager()->createQuery($dql);
        
        return $query->getResult();
    }    
}