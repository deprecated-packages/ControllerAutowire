<?php

/*
 * This file is part of Zenify
 * Copyright (c) 2015 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Zenify\ControllerAutowire\HttpKernel\Controller;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;

final class ControllerResolver implements ControllerResolverInterface
{
    /**
     * @var ControllerResolverInterface
     */
    private $controllerResolver;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var string[]
     */
    private $controllerClassMap;

    public function __construct(ControllerResolverInterface $controllerResolver, ContainerInterface $container)
    {
        $this->controllerResolver = $controllerResolver;
        $this->container = $container;
    }

    public function setControllerClassMap(array $controllerClassMap)
    {
        $this->controllerClassMap = array_flip($controllerClassMap);
    }

    /**
     * {@inheritdoc}
     */
    public function getController(Request $request)
    {
        if (!$controllerName = $request->attributes->get('_controller')) {
            return false;
        }

        if ($this->isClassController($controllerName)) {
            return $this->controllerResolver->getController($request);
        }

        list($class, $method) = explode('::', $controllerName, 2);

        if (!isset($this->controllerClassMap[$class])) {
            return $this->controllerResolver->getController($request);
        }

        $controller = $this->getControllerService($class);
        $controller = $this->decorateControllerWithContainer($controller);

        return [$controller, $method];
    }

    /**
     * {@inheritdoc}
     */
    public function getArguments(Request $request, $controller)
    {
        return $this->controllerResolver->getArguments($request, $controller);
    }

    /**
     * @param string $controllerName
     *
     * @return bool
     */
    private function isClassController($controllerName)
    {
        return false === strpos($controllerName, '::');
    }

    /**
     * @param string $class
     *
     * @return object
     */
    private function getControllerService($class)
    {
        $serviceName = $this->controllerClassMap[$class];

        return $this->container->get($serviceName);
    }

    /**
     * @param object $controller
     *
     * @return object
     */
    private function decorateControllerWithContainer($controller)
    {
        if ($controller instanceof ContainerAwareInterface) {
            $controller->setContainer($this->container);
        }

        return $controller;
    }
}
