<?php

/*
 * This file is part of Symotion
 * Copyright (c) 2015 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symotion\ControllerAutowire\Contract\DependencyInjection;

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
