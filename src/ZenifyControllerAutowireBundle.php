<?php

/*
 * This file is part of Zenify
 * Copyright (c) 2015 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Zenify\ControllerAutowire;

use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Zenify\ControllerAutowire\DependencyInjection\ControllerClassMap;
use Zenify\ControllerAutowire\DependencyInjection\Compiler\DefaultAutowireTypesPass;
use Zenify\ControllerAutowire\DependencyInjection\Compiler\RegisterControllersPass;
use Zenify\ControllerAutowire\DependencyInjection\Compiler\ReplaceControllerResolverPass;
use Zenify\ControllerAutowire\DependencyInjection\Extension\ContainerExtension;
use Zenify\ControllerAutowire\HttpKernel\Controller\ControllerFinder;

final class ZenifyControllerAutowireBundle extends Bundle
{
    /**
     * @var string
     */
    const ALIAS = 'zenify_controller_autowire';

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
