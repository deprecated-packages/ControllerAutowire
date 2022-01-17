<?php declare(strict_types=1);

namespace TomasVotruba\SymfonyLegacyControllerAutowire\Tests\DependencyInjection\Extension;

use PHPUnit\Framework\TestCase;
use TomasVotruba\SymfonyLegacyControllerAutowire\DependencyInjection\Extension\ContainerExtension;
use TomasVotruba\SymfonyLegacyControllerAutowire\SymplifyControllerAutowireBundle;

final class ContainerExtensionTest extends TestCase
{
    public function testGetAlias(): void
    {
        $containerExtension = new ContainerExtension;
        $this->assertSame(SymplifyControllerAutowireBundle::ALIAS, $containerExtension->getAlias());
    }
}
