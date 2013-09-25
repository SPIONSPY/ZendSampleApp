<?php 

namespace Shop\Controller;

use Base\Debug\Debug;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Shop\Service\ShopManager;
use Shop\Form\ProductForm;
use Shop\Entity\Product;

class ProductController extends AbstractActionController
{
	public function indexAction() {
	    
	    $serviceLocator = $this->getServiceLocator();
	    $shopManager = $serviceLocator->get(ShopManager::class);

	    $products = $shopManager->findProducts();
	    
		$view = new ViewModel([
			'products' => $products ,
		]);
		
		return $view;
	}

	public function addAction() {

	    $serviceLocator = $this->getServiceLocator();
	    $shopManager = $serviceLocator->get(ShopManager::class);
	     
	    $form = new ProductForm();
	    $form->get('submit')->setValue('Add');
	     
	    $request = $this->getRequest();
	    
	    if ($request->isPost()) {
	        $product = new Product();
	        $form->setInputFilter($product->getInputFilter());
	        $form->setData($request->getPost());
	         
	        if ($form->isValid()) {
	            $product->exchangeArray($form->getData());
	            $shopManager->saveProduct($product);
	             
	            return $this->redirect()->toRoute('shop/product');
	        }
	    }
	    
	    return array('form' => $form);	     
	}

	public function editAction() {

	    $serviceLocator = $this->getServiceLocator();
	    $shopManager = $serviceLocator->get(ShopManager::class);
	     
	    $id = (int) $this->params()->fromRoute('id', 0);
	    
	    if (empty($id)) { // id not provided
	        return $this->redirect()->toRoute('shop/product');	        
	    }

	    $product = $shopManager->findProduct($id); // get product by id
	    	  
	    if (empty($product)) { // product doesn't exist
	        return $this->redirect()->toRoute('shop/product');
	    }
	     
	    $form  = new ProductForm();
	    $form->bind($product);
	    $form->get('submit')->setAttribute('value', 'Edit');
	     
	    $request = $this->getRequest();
	    if ($request->isPost()) {
	        $form->setInputFilter($product->getInputFilter());
	        $form->setData($request->getPost());
	         
	        if ($form->isValid()) {
	            
	            $shopManager->saveProduct($product);
	            
	            return $this->redirect()->toRoute('shop/product');
	        }
	    }
	     
	    return array(
	        'id' => $id,
	        'form' => $form,
	    );	     
	}
	
	public function deleteAction() {

	    $serviceLocator = $this->getServiceLocator();
	    $shopManager = $serviceLocator->get(ShopManager::class);
	    
	    $id = (int) $this->params()->fromRoute('id', 0);
	    
	    if (empty($id)) {
	        return $this->redirect()->toRoute('shop/product');
	    }

	    $product = $shopManager->findProduct($id); // get product by id
	    
	    if (empty($product)) { // product doesn't exist
	        return $this->redirect()->toRoute('shop/product');
	    }
	     
	    $request = $this->getRequest();
	    if ($request->isPost()) {
	        $del = $request->getPost('del', 'No');
	         
	        if ($del == 'Yes') {
	            $shopManager->removeProduct($product);
	        }
	         
	        return $this->redirect()->toRoute('shop/product');
	    }
	     
	    return array(
	        'id'    => $id,
	        'product' => $product
	    );
	}	
	
	public function viewAction() {
	    
	    $serviceLocator = $this->getServiceLocator();
	    $shopManager = $serviceLocator->get(ShopManager::class);
	    
	    $slug = $this->params()->fromRoute('slug', null);
	    $product = $shopManager->findProductBySlug($slug); // get product by slug
	     
	    if (empty($product)) { // product doesn't exist
	        return $this->redirect()->toRoute('shop/product');
	    }
	    
	    $view = new ViewModel([
	        'product' => $product,
	    ]);
	    
	    return $view;
	}
}