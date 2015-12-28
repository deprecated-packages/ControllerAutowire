<?php

/*
 * This file is part of Symotion
 * Copyright (c) 2015 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symotion\ControllerAutowire;

use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symotion\ControllerAutowire\DependencyInjection\ControllerClassMap;
use Symotion\ControllerAutowire\DependencyInjection\Compiler\DefaultAutowireTypesPass;
use Symotion\ControllerAutowire\DependencyInjection\Compiler\RegisterControllersPass;
use Symotion\ControllerAutowire\DependencyInjection\Compiler\ReplaceControllerResolverPass;
use Symotion\ControllerAutowire\DependencyInjection\Extension\ContainerExtension;
use Symotion\ControllerAutowire\HttpKernel\Controller\ControllerFinder;

final class SymotionControllerAutowireBundle extends Bundle
{
    /**
     * @var string
     */
    const ALIAS = 'symotion_controller_autowire';

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $controllerClassMap = new ControllerClassMap();
        $controllerFinder = new ControllerFinder();

        $container->addCompilerPass(new RegisterControllersPass($controllerClassMap, $controllerFinder));
        $container->addCompilerPass(new DefaultAutowireTypesPass());

        $container->addCompilerPass(new ReplaceControllerResolverPass($controllerClassMap), PassConfig::TYPE_OPTIMIZE);
    }

    /**
     * {@inheritdoc}
     */
    public function createContainerExtension()
    {
        return new ContainerExtension();
    }
}
