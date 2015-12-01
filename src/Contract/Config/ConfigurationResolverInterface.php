<?php

/*
 * This file is part of Zenify
 * Copyright (c) 2015 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Zenify\ControllerAutowire\Contract\Config;

use Symfony\Component\DependencyInjection\ContainerBuilder;

interface ConfigurationResolverInterface
{
    /**
     * @return string[][]
     */
    public function resolveFromContainerBuilder(ContainerBuilder $containerBuilder);
}
