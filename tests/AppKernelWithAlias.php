<?php

namespace Symotion\ControllerAutowire\Tests;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symotion\ControllerAutowire\Tests\AliasingBundle\AliasingBundle;
use Symotion\ControllerAutowire\SymotionControllerAutowireBundle;

final class AppKernelWithAlias extends Kernel
{
    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new SymotionControllerAutowireBundle(),
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
