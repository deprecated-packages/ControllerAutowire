<?php

/*
 * This file is part of Zenify
 * Copyright (c) 2015 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Zenify\ControllerAutowire\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Zenify\ControllerAutowire\Contract\DependencyInjection\ControllerClassMapInterface;
use Zenify\ControllerAutowire\HttpKernel\ControllerResolver;

final class ReplaceControllerResolverPass implements CompilerPassInterface
{
    /**
     * @var string
     */
    const CONTROLLER_RESOLVER_SERVICE_NAME = 'controller_resolver';

    /**
     * @var ControllerClassMapInterface
     */
    private $controllerClassMap;

    public function __construct(ControllerClassMapInterface $controllerClassMap)
    {
        $this->controllerClassMap = $controllerClassMap;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $containerBuilder)
    {
        if ($containerBuilder->hasDefinition(self::CONTROLLER_RESOLVER_SERVICE_NAME)) {
            $oldResolver = $containerBuilder->getDefinition(self::CONTROLLER_RESOLVER_SERVICE_NAME);
            $containerBuilder->setDefinition('old.'.self::CONTROLLER_RESOLVER_SERVICE_NAME, $oldResolver);
            $containerBuilder->removeDefinition(self::CONTROLLER_RESOLVER_SERVICE_NAME);
        }

        $definition = new Definition(ControllerResolver::class);
        $definition->addMethodCall('setControllerClassMap', [$this->controllerClassMap->getControllers()]);
        $definition->setArguments([
            new Reference('old.'.self::CONTROLLER_RESOLVER_SERVICE_NAME),
            new Reference('service_container'),
        ]);

        $containerBuilder->setDefinition(self::CONTROLLER_RESOLVER_SERVICE_NAME, $definition);
    }
}
