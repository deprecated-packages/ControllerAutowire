<?php

/*
 * This file is part of Symotion
 * Copyright (c) 2015 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symotion\ControllerAutowire\DependencyInjection\Extension;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symotion\ControllerAutowire\SymotionControllerAutowireBundle;

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
        return SymotionControllerAutowireBundle::ALIAS;
    }
}
