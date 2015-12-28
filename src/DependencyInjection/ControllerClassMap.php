<?php

/*
 * This file is part of Symotion
 * Copyright (c) 2015 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symotion\ControllerAutowire\DependencyInjection;

use Symotion\ControllerAutowire\Contract\DependencyInjection\ControllerClassMapInterface;

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
