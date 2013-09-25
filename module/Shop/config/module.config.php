<?php

namespace Shop;

use Base\Mvc\Router\Http\Bad as BadRoute;

use Shop\Service\ShopManager;
use Shop\Service\ShopManagerFactory;

use Shop\Controller\ProductController;

return array(
    'shop_manager' => array(
    ),
    'service_manager' => array(
        'factories' => array(
            ShopManager::class => ShopManagerFactory::class,
        )        
    ),
    'controllers' => array(
        'invokables' => array(
             ProductController::class => ProductController::class,
        ),
    ),
    'router' => array(
        'routes' => array(
            'shop' => array( // module name
                'type' => BadRoute::class,
                'may_terminate' => false,
                'child_routes' => array(
                    'product' => array( // controller name
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => '/products',
                            'constraints' => array(
                            ),
                            'defaults' => array(
                                'controller' => ProductController::class,
                                'action'     => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'add' => array( // action name
                                'type'    => 'segment',
                                'options' => array(
                                    'route'    => '/add',
                                    'constraints' => array(
                                    ),
                                    'defaults' => array(
                                        'action'     => 'add',
                                    ),
                                ),
                            ),                            
                            'view' => array( // action name
                                'type'    => 'segment',
                                'options' => array(
                                    'route'    => '/view/:slug',
                                    'constraints' => array(
                                        'slug' => '[a-zA-Z0-9_-]*',
                                    ),
                                    'defaults' => array(
                                        'action'     => 'view',
                                    ),
                                ),
                            ),
                            'edit' => array( // action name
                                'type'    => 'segment',
                                'options' => array(
                                    'route'    => '/edit/:id',
                                    'constraints' => array(
                                        'id' => '[0-9]*',
                                    ),
                                    'defaults' => array(
                                        'action'     => 'edit',
                                    ),
                                ),
                            ),
                            'delete' => array( // action name
                                'type'    => 'segment',
                                'options' => array(
                                    'route'    => '/delete/:id',
                                    'constraints' => array(
                                        'slug' => '[0-9]*',
                                    ),
                                    'defaults' => array(
                                        'action'     => 'delete',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),    
    'view_manager' => array(
        'template_path_stack' => array(
            'shop' => __DIR__ . '/../view',
        ),
    ),
    'asset_manager' => array(
        'resolver_configs' => array(
            'paths' => array(
                __DIR__ . '/../public',
            ),
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity',
                ),
            ),    
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                ),
            ),
        ),
    ),            
);