<?php

namespace Zenify\ControllerAutowire\Tests\DependencyInjection\Compiler;

use PHPUnit_Framework_TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Zenify\ControllerAutowire\DependencyInjection\Compiler\DefaultAutowireTypesPass;

final class DefaultAutowireTypesPassTest extends PHPUnit_Framework_TestCase
{
    public function testProcess()
    {
        $defaultAutowireTypesPass = new DefaultAutowireTypesPass();

        $containerBuilder = new ContainerBuilder();
        $containerBuilder->setParameter('kernel.root_dir', __DIR__);

        $definition = new Definition('Doctrine\ORM\EntityManagerInterface');
        $containerBuilder->setDefinition('doctrine.orm.default_entity_manager', $definition);
        $this->assertSame([], $definition->getAutowiringTypes());

        $defaultAutowireTypesPass->process($containerBuilder);

        $definition = $containerBuilder->getDefinition('doctrine.orm.default_entity_manager');
        $this->assertSame(['Doctrine\ORM\EntityManagerInterface'], $definition->getAutowiringTypes());
    }
}
