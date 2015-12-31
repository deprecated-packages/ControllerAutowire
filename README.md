# Controller Autowire

[![Build Status](https://img.shields.io/travis/Symplify/ControllerAutowire.svg?style=flat-square)](https://travis-ci.org/Symplify/ControllerAutowire)
[![Quality Score](https://img.shields.io/scrutinizer/g/Symplify/ControllerAutowire.svg?style=flat-square)](https://scrutinizer-ci.com/g/Symplify/ControllerAutowire)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/Symplify/ControllerAutowire.svg?style=flat-square)](https://scrutinizer-ci.com/g/Symplify/ControllerAutowire)
[![Downloads](https://img.shields.io/packagist/dt/symplify/controller-autowire.svg?style=flat-square)](https://packagist.org/packages/symplify/controller-autowire)
[![Latest stable](https://img.shields.io/packagist/v/symplify/controller-autowire.svg?style=flat-square)](https://packagist.org/packages/symplify/controller-autowire)

If you still wonder **why using controller as services**, **check few arguments** about this topic:

- [Richar Miller - Symfony2: Controller as Service](http://richardmiller.co.uk/2011/04/15/symfony2-controller-as-service)
- [Matthias Noback - How to create framework independent controllers](http://php-and-symfony.matthiasnoback.nl/2014/06/how-to-create-framework-independent-controllers/)
 
Later, you would [find tutorials, how to do it](http://stackoverflow.com/a/31366589/1348344).

In short, it requires these 3 steps: 

- @Route service annotations
- custom syntax for routes
- explicit controller service registration

**This bundle removes these steps** and **enables controllers as service** for you. 

## Install

```bash
$ composer require symplify/controller-autowire
```

Add bundle to `AppKernel.php`:

```php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symplify\ControllerAutowire\SymplifyControllerAutowireBundle(),
            // ...
        ];
    }
}
```


## Usage

```php
class SomeController // ...
{
    private $someClass;

    public function __construct(SomeClass $someClass)
    {
        $this->someClass = $someClass;
    }
}
```

That's all :)


# Testing

```bash
$ vendor/bin/phpunit
```


# Contributing

Rules are simple:

- new feature needs tests
- all tests must pass
- 1 feature per PR

I'd be happy to merge your feature then.
