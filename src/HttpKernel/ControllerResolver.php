<?php

/*
 * This file is part of Zenify
 * Copyright (c) 2015 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Zenify\ControllerAutowire\HttpKernel;

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
     * @var \string[]
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
        if (!$controller = $request->attributes->get('_controller')) {
            return false;
        }

        if (false !== strpos($controller, '::')) {
            list($class, $method) = explode('::', $controller, 2);

            if (isset($this->controllerClassMap[$class])) {
                $controller = $this->container->get($this->controllerClassMap[$class]);

                if ($controller instanceof ContainerAwareInterface) {
                    $controller->setContainer($this->container);
                }

                return [$controller, $method];
            }
        }

        return $this->controllerResolver->getController($request);
    }

    /**
     * {@inheritdoc}
     */
    public function getArguments(Request $request, $controller)
    {
    }
}
