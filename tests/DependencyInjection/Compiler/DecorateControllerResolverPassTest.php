<?php declare(strict_types=1);

namespace TomasVotruba\SymfonyLegacyControllerAutowire\Tests\DependencyInjection\Compiler;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use TomasVotruba\SymfonyLegacyControllerAutowire\DependencyInjection\Compiler\DecorateControllerResolverPass;
use TomasVotruba\SymfonyLegacyControllerAutowire\DependencyInjection\ControllerClassMap;

final class DecorateControllerResolverPassTest extends TestCase
{
    /**
     * @var ControllerClassMap
     */
    private $controllerClassMap;

    protected function setUp(): void
    {
        $this->controllerClassMap = new ControllerClassMap;
    }

    public function testInjectionOfOldDecoratedService(): void
    {
        $containerBuilder = new ContainerBuilder;

        $resolver = new DecorateControllerResolverPass($this->controllerClassMap);
        $resolver->process($containerBuilder);

        $definition = $containerBuilder->getDefinition('symplify.controller_resolver');
        $this->assertSame('symplify.controller_resolver.inner', (string) $definition->getArgument(0));
    }
}
