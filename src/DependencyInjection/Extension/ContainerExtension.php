<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2015 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\ControllerAutowire\DependencyInjection\Extension;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Zenify\ControllerAutowire\ZenifyControllerAutowireBundle;

final class ContainerExtension implements ExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $containerBuilder)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getNamespace()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getXsdValidationBasePath()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return ZenifyControllerAutowireBundle::ALIAS;
    }
}
