<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2015 Tomas Votruba (http://tomasvotruba.cz).
 */
namespace Zenify\ControllerAutowire\Tests\HttpKernel\Controller;

use PHPUnit_Framework_TestCase;
use Zenify\ControllerAutowire\Contract\HttpKernel\ControllerFinderInterface;
use Zenify\ControllerAutowire\HttpKernel\Controller\ControllerFinder;
use Zenify\ControllerAutowire\Tests\HttpKernel\Controller\ControllerFinderSource\SomeController;
use Zenify\ControllerAutowire\Tests\HttpKernel\Controller\ControllerFinderSource\SomeOtherController;

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

        $this->assertEquals(
            [SomeController::class, SomeOtherController::class],
            $controllers,
            '',
            0.0,
            10,
            true
        );
    }
}
