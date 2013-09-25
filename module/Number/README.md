# Number module for Zend Framework 2

This module converts integers to roman numerals and vice-versa

Requirements:

- PHP 5.5
- Zend Framework 2
        
## Instalation
 
Instalation with composer is not currently available so for now just clone this into your modules folder.

Then add 'Number' into the Module array in APPLICATION_ROOT/config/application.config.php

```php
<?php
return array(
    'modules' => array(
        ...
        'Number',
        ...
    ),
);
```

## Accessing NumberConverter from a controller

NumberConverter module is accessible via Service Locator:

```php
$numberConverter = $this->getServiceLocator()->get('NumberConverter');
```

When you obtain the service and create the object, you can then use it to do the magic:

```php
$romanNumeral = $numberConverter->integerToRomanNumeral(1990));
$integer = $numberConverter->romanNumeralToInteger('MCMXC'));
```

## Accessing NumberConverter helpers from a view

NumberConverter module provides two helpers accessible from a view:

```php
Roman: <?= $this->integerToRomanNumeral(1990) ?>
Integer: <?= $this->romanNumeralToInteger('MCMXC') ?>
```
