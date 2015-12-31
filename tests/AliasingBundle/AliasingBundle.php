<?php

namespace Symplify\ControllerAutowire\Tests\AliasingBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\ControllerAutowire\Tests\AliasingBundle\DependencyInjection\AliasingExtension;
use Symplify\ControllerAutowire\Tests\AliasingBundle\DependencyInjection\Compiler\AliasingCompilerPass;

final class AliasingBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $containerBuilder)
    {
        $containerBuilder->addCompilerPass(new AliasingCompilerPass());
    }

    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new AliasingExtension();
    }
}
