<?php declare(strict_types=1);

namespace TomasVotruba\SymfonyLegacyControllerAutowire\Tests\HttpKernel\Controller;

use PHPUnit\Framework\TestCase;
use TomasVotruba\SymfonyLegacyControllerAutowire\Contract\HttpKernel\ControllerFinderInterface;
use TomasVotruba\SymfonyLegacyControllerAutowire\HttpKernel\Controller\ControllerFinder;
use TomasVotruba\SymfonyLegacyControllerAutowire\Tests\HttpKernel\Controller\ControllerFinderSource\SomeController;
use TomasVotruba\SymfonyLegacyControllerAutowire\Tests\HttpKernel\Controller\ControllerFinderSource\SomeOtherController;

final class ControllerFinderTest extends TestCase
{
    /**
     * @var ControllerFinderInterface
     */
    private $controllerFinder;

    protected function setUp(): void
    {
        $this->controllerFinder = new ControllerFinder;
    }

    public function testFindControllersInDirs(): void
    {
        $controllers = $this->controllerFinder->findControllersInDirs([__DIR__ . '/ControllerFinderSource']);
        $this->assertCount(2, $controllers);

        $this->assertContains(SomeOtherController::class, $controllers);
        $this->assertContains(SomeController::class, $controllers);

        $this->assertArrayHasKey(
            'symplify.controllerautowire.tests.httpkernel.controller.controllerfindersource.somecontroller',
            $controllers
        );
    }
}
