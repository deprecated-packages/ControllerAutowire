<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2015 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\ControllerAutowire\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symplify\ControllerAutowire\Config\Definition\ConfigurationResolver;
use Symplify\ControllerAutowire\Contract\DependencyInjection\ControllerClassMapInterface;
use Symplify\ControllerAutowire\Contract\HttpKernel\ControllerFinderInterface;

final class RegisterControllersPass implements CompilerPassInterface
{
    /**
     * @var ControllerClassMapInterface
     */
    private $controllerClassMap;

    /**
     * @var ControllerFinderInterface
     */
    private $controllerFinder;

    public function __construct(ControllerClassMapInterface $controllerClassMap, ControllerFinderInterface $controllerFinder)
    {
        $this->controllerClassMap = $controllerClassMap;
        $this->controllerFinder = $controllerFinder;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $containerBuilder)
    {
        $controllerDirs = $this->getControllerDirs($containerBuilder);
        $controllers = $this->controllerFinder->findControllersInDirs($controllerDirs);
        $this->registerControllersToContainerBuilder($controllers, $containerBuilder);
    }

    /**
     * @return string[]
     */
    private function getControllerDirs(ContainerBuilder $containerBuilder)
    {
        $config = (new ConfigurationResolver())->resolveFromContainerBuilder($containerBuilder);

        return $config['controller_dirs'];
    }

    private function registerControllersToContainerBuilder(array $controllers, ContainerBuilder $containerBuilder)
    {
        foreach ($controllers as $controller) {
            $id = $this->buildControllerIdFromClass($controller);
            $definition = $this->buildControllerDefinitionFromClass($controller);

            $containerBuilder->setDefinition($id, $definition);
            $this->controllerClassMap->addController($id, $controller);
        }
    }

    /**
     * @param string $class
     *
     * @return string
     */
    private function buildControllerIdFromClass($class)
    {
        return strtr(strtolower($class), ['\\' => '.']);
    }

    /**
     * @param string $class
     *
     * @return Definition
     */
    private function buildControllerDefinitionFromClass($class)
    {
        $definition = new Definition($class);
        $definition->setAutowired(true);

        return $definition;
    }
}
