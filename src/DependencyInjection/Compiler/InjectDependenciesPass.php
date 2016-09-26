<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2015 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\ControllerAutowire\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symplify\ControllerAutowire\Config\Definition\ConfigurationResolver;
use Symplify\ControllerAutowire\Contract\DependencyInjection\ControllerClassMapInterface;
use Symplify\ControllerAutowire\Contract\HttpKernel\ControllerFinderInterface;

final class InjectDependenciesPass implements CompilerPassInterface
{
    /**
     * @var ControllerClassMapInterface
     */
    private $controllerClassMap;

    /**
     * @var ControllerFinderInterface
     */
    private $controllerFinder;

    public function __construct(
        ControllerClassMapInterface $controllerClassMap,
        ControllerFinderInterface $controllerFinder
    ) {
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
        $this->injectDependenciesToController($controllers, $containerBuilder);
    }

    /**
     * @return string[]
     */
    private function getControllerDirs(ContainerBuilder $containerBuilder) : array
    {
        $config = (new ConfigurationResolver())->resolveFromContainerBuilder($containerBuilder);

        return $config['controller_dirs'];
    }

    private function injectDependenciesToController(array $controllers, ContainerBuilder $containerBuilder)
    {
        foreach ($controllers as $controller) {
            $id = $this->buildControllerIdFromClass($controller);
            $controllerDefinition = $containerBuilder->findDefinition($id);
            $this->injectDependencies($controllerDefinition);
        }
    }

    private function buildControllerIdFromClass(string $class) : string
    {
        return strtr(strtolower($class), ['\\' => '.']);
    }

    /**
     * @param Definition $definition
     *
     * @return Definition
     */
    private function injectDependencies(Definition $definition) : Definition
    {
        if (method_exists($definition->getClass(), 'setDoctrineRegistry')) {
            //        if (array_key_exists('Symplify\ControllerAutowire\DependencyInjection\ControllerAwareTrait',
//            class_uses($definition->getClass()))) {
            $definition->addMethodCall('setDoctrineRegistry', [new Reference('doctrine')]);
        }

        return $definition;
    }
}
