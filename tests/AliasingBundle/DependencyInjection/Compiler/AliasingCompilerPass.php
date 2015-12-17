<?php

namespace Zenify\ControllerAutowire\Tests\AliasingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * This is done by JMSDiExtraBundle.
 *
 * @see https://github.com/adam187/JMSDiExtraBundle/blob/59b9745f6d02dcaee69b8a78a22119475d26273f/DependencyInjection/Compiler/IntegrationPass.php#L37
 *
 * And might be done by others of course.
 *
 * It disables decoration for controller_resolver.
 */
final class AliasingCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $containerBuilder)
    {
        $containerBuilder->setAlias('controller_resolver', new Alias('some_alias.controller_resolver', false));
    }
}
