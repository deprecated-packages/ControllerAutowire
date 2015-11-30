<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2015 Tomas Votruba (http://tomasvotruba.cz).
 */
namespace Zenify\ControllerAutowire\Tests\HttpKernel;

use PHPUnit_Framework_TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Zenify\ControllerAutowire\HttpKernel\ControllerResolver;

final class ControllerResolverTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ControllerResolver
     */
    private $controllerResolver;

    protected function setUp()
    {
        $parentControllerResolverMock = $this->prophesize(ControllerResolverInterface::class);
        $containerMock = $this->prophesize(ContainerInterface::class);
        $this->controllerResolver = new ControllerResolver(
            $parentControllerResolverMock->reveal(), $containerMock->reveal()
        );
    }

    public function testGetController()
    {
        $request = new Request();
        $request->attributes->set('_controller', 'SomeController::someAction');

        $controller = $this->controllerResolver->getController($request);
        $this->assertNull($controller);
    }

    public function testGetArguments()
    {
        $this->assertNull(
            $this->controllerResolver->getArguments(new Request(), 'missing')
        );
    }
}
