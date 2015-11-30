<?php

/*
 * This file is part of Zenify
 * Copyright (c) 2015 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Zenify\ControllerAutowire\DependencyInjection\Compiler;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Definition;
use Zenify\ControllerAutowire\Config\Definition\Configuration;
use Zenify\ControllerAutowire\Contract\DependencyInjection\ControllerClassMapInterface;
use Zenify\ControllerAutowire\Contract\HttpKernel\ControllerFinderInterface;
use Zenify\ControllerAutowire\ZenifyControllerAutowireBundle;

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
        $config = $this->getResolvedConfig($containerBuilder);

        $controllers = $this->controllerFinder->findControllersInDirs($config['controller_dirs']);
        $this->registerControllersToContainerBuilder($controllers, $containerBuilder);
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
     * @return string[]
     */
    private function getResolvedConfig(ContainerBuilder $containerBuilder)
    {
        $processor = new Processor();
        $configs = $containerBuilder->getExtensionConfig(ZenifyControllerAutowireBundle::ALIAS);
        $configs = $processor->processConfiguration(new Configuration(), $configs);

        return $containerBuilder->getParameterBag()->resolveValue($configs);
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
