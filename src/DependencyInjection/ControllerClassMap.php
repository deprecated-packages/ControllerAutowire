<?php

/*
 * This file is part of Zenify
 * Copyright (c) 2015 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Zenify\ControllerAutowire\DependencyInjection;

use Zenify\ControllerAutowire\Contract\DependencyInjection\ControllerClassMapInterface;

final class ControllerClassMap implements ControllerClassMapInterface
{
    /**
     * @var string[]
     */
    private $controllers = [];

    /**
     * {@inheritdoc}
     */
    public function addController($id, $class)
    {
        $this->controllers[$id] = $class;
    }

    /**
     * {@inheritdoc}
     */
    public function getControllers()
    {
        return $this->controllers;
    }
}
