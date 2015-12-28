<?php

/*
 * This file is part of Symotion
 * Copyright (c) 2015 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symotion\ControllerAutowire\Contract\Config;

use Symfony\Component\DependencyInjection\ContainerBuilder;

interface ConfigurationResolverInterface
{
    /**
     * @return string[][]
     */
    public function resolveFromContainerBuilder(ContainerBuilder $containerBuilder);
}
