<?php

namespace Number;

use Number\Service\NumberConverter;

return array(
    'service_manager' => array(
        'invokables' => array(
            'NumberConverter' => NumberConverter::class,
        )        
    ),            
);