# Controller Autowire

Use controller's constructor to get dependencies with ease.

- no @Route annotations
- no special syntax for routes
- no explicit controller service registration

## Install

```bash
$ composer require zenify/controller-autowire
```

Add bundle to `AppKernel.php`:

```php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Zenify\ControllerAutowire\ZenifyControllerAutowireBundle(),
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

    public function __constructor(SomeClass $someClass)
    {
        $this->someClass = $someClass;
    }
}
```

That's all :)


# Testing

```bash
phpunit
```


# Contributing

Rules are simple:

- new feature needs tests
- all tests must pass
- 1 feature per PR

I'd be happy to merge your feature then.
