<?php

/*
 * This file is part of Symotion
 * Copyright (c) 2015 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symotion\ControllerAutowire\HttpKernel\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\ControllerNameParser;
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
     * @var ControllerNameParser
     */
    private $controllerNameParser;

    /**
     * @var string[]
     */
    private $controllerClassMap;

    public function __construct(
        ControllerResolverInterface $controllerResolver,
        ContainerInterface $container,
        ControllerNameParser $controllerNameParser
    ) {
        $this->controllerResolver = $controllerResolver;
        $this->container = $container;
        $this->controllerNameParser = $controllerNameParser;
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

        list($class, $method) = $this->splitControllerClassAndMethod($controllerName);
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

    /**
     * @param string $controllerName
     *
     * @return array
     */
    private function splitControllerClassAndMethod($controllerName)
    {
        if (false !== strpos($controllerName, '::')) {
            return explode('::', $controllerName, 2);
        } elseif (substr_count($controllerName, ':') === 2) {
            $controllerName = $this->controllerNameParser->parse($controllerName);

            return explode('::', $controllerName, 2);
        } elseif (false !== strpos($controllerName, ':')) {
            return explode(':', $controllerName, 2);
        }
    }
}
