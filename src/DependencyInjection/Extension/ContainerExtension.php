<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2015 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\ControllerAutowire\DependencyInjection\Extension;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symplify\ControllerAutowire\SymplifyControllerAutowireBundle;

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
        return SymplifyControllerAutowireBundle::ALIAS;
    }
}
