<?php

namespace Symotion\ControllerAutowire\Tests\DependencyInjection\Extension;

use PHPUnit_Framework_TestCase;
use Symotion\ControllerAutowire\DependencyInjection\Extension\ContainerExtension;

final class ContainerExtensionTest extends PHPUnit_Framework_TestCase
{
    public function testGetters()
    {
        $containerExtension = new ContainerExtension();
        $this->assertNull($containerExtension->getXsdValidationBasePath());
    }
}
