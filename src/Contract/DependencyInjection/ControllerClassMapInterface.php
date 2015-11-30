<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2015 Tomas Votruba (http://tomasvotruba.cz).
 */
namespace Zenify\ControllerAutowire\Contract\DependencyInjection;

interface ControllerClassMapInterface
{
    /**
     * @param string $id
     * @param string $class
     */
    public function addController($id, $class);

    /**
     * @return string[]
     */
    public function getControllers();
}
