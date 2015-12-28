<?php

namespace Symotion\ControllerAutowire\Tests;

use PHPUnit_Framework_TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Tests\Controller;
use Symotion\ControllerAutowire\HttpKernel\Controller\ControllerResolver;
use Symotion\ControllerAutowire\Tests\CompleteTestSource\DoNotScan\SomeRegisteredController;
use Symotion\ControllerAutowire\Tests\CompleteTestSource\Scan\ContainerAwareController;
use Symotion\ControllerAutowire\Tests\HttpKernel\Controller\ControllerFinderSource\SomeController;
use Symotion\ControllerAutowire\Tests\HttpKernel\Controller\ControllerFinderSource\SomeService;

final class CompleteTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ControllerResolver
     */
    private $controllerResolver;

    protected function setUp()
    {
        $kernel = new AppKernel('test_env', true);
        $kernel->boot();

        $this->controllerResolver = $kernel->getContainer()
            ->get('controller_resolver');
    }

    public function testControllerResolver()
    {
        $this->assertInstanceOf(ControllerResolver::class, $this->controllerResolver);
    }

    public function testMissingControllerParameter()
    {
        $request = new Request();
        $this->assertFalse($this->controllerResolver->getController($request));
    }

    public function testGetAutowiredController()
    {
        $request = new Request();
        $request->attributes->set('_controller', SomeController::class.'::someAction');

        /** @var SomeController $controller */
        $controller = $this->controllerResolver->getController($request)[0];

        $this->assertInstanceOf(SomeController::class, $controller);
        $this->assertInstanceOf(SomeService::class, $controller->getSomeService());
    }

    public function testGetContainerAwareController()
    {
        $request = new Request();
        $request->attributes->set('_controller', ContainerAwareController::class.'::someAction');

        /** @var ContainerAwareController $controller */
        $controller = $this->controllerResolver->getController($request)[0];

        $this->assertInstanceOf(ContainerAwareController::class, $controller);
        $this->assertInstanceOf(ContainerInterface::class, $controller->getContainer());
    }

    public function testGetControllerServiceMissing()
    {
        $request = new Request();
        $request->attributes->set('_controller', 'some.missing.controller.service:someAction');

        $this->setExpectedException(ServiceNotFoundException::class);
        $this->controllerResolver->getController($request);
    }

    public function testGetControllerServiceRegisteredInConfig()
    {
        $request = new Request();
        $request->attributes->set('_controller', 'some.controller.service:someAction');

        $controller = $this->controllerResolver->getController($request)[0];
        $this->assertInstanceOf(SomeRegisteredController::class, $controller);
    }
}
