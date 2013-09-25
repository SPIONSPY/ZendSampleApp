ZendSampleApp
=======================

Introduction
------------
This is a simple application using the ZF2 MVC layer, module systems, Forms, AssetManager 
and Doctrine. The application allows viewing/adding/editing products.

Installation
------------

Application was tested on an AWS EC2 instance with Ubuntu 12.04 LTS.
Environment was setup using: https://github.com/alexgociu/setup-server

Clone the repository and manually invoke `composer` using the shipped `composer.phar`:

```
cd my/project/dir
git clone git://github.com/alexgociu/ZendSampleApp.git
cd ZendSampleApp
php composer.phar self-update
php composer.phar install
```

(The `self-update` directive is to ensure you have an up-to-date `composer.phar`
available.)

Create config file and add database connection details:

```
cp ./config/autoload/local.php.dist ./config/autoload/local.php
```

Create the database:

```
./vendor/bin/doctrine-module orm:schema-tool:create
```


