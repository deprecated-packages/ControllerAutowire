<?php

namespace Symplify\ControllerAutowire\Tests;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symplify\ControllerAutowire\SymplifyControllerAutowireBundle;
use Symplify\ControllerAutowire\Tests\AliasingBundle\AliasingBundle;

final class AppKernelWithAlias extends Kernel
{
    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new SymplifyControllerAutowireBundle(),
            new AliasingBundle(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/Resources/config/config.yml');
    }
}
