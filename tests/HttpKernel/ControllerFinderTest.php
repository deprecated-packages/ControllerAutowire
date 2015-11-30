<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2015 Tomas Votruba (http://tomasvotruba.cz).
 */
namespace Zenify\ControllerAutowire\Tests\HttpKernel;

use PHPUnit_Framework_TestCase;
use Zenify\ControllerAutowire\Contract\HttpKernel\ControllerFinderInterface;
use Zenify\ControllerAutowire\HttpKernel\ControllerFinder;
use Zenify\ControllerAutowire\Tests\HttpKernel\ControllerFinderSource\SomeController;
use Zenify\ControllerAutowire\Tests\HttpKernel\ControllerFinderSource\SomeOtherController;

final class ControllerFinderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ControllerFinderInterface
     */
    private $controllerFinder;

    protected function setUp()
    {
        $this->controllerFinder = new ControllerFinder();
    }

    public function testFindControllersInDirs()
    {
        $controllers = $this->controllerFinder->findControllersInDirs([__DIR__.'/ControllerFinderSource']);

        $this->assertSame(
            [SomeOtherController::class, SomeController::class],
            $controllers
        );
    }
}
