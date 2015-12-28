<?php

/*
 * This file is part of Symotion
 * Copyright (c) 2015 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symotion\ControllerAutowire\Config\Definition;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symotion\ControllerAutowire\Contract\Config\ConfigurationResolverInterface;
use Symotion\ControllerAutowire\SymotionControllerAutowireBundle;

final class ConfigurationResolver implements ConfigurationResolverInterface
{
    /**
     * @var string[]
     */
    private $resolvedConfiguration;

    /**
     * {@inheritdoc}
     */
    public function resolveFromContainerBuilder(ContainerBuilder $containerBuilder)
    {
        if (!$this->resolvedConfiguration) {
            $processor = new Processor();
            $configs = $containerBuilder->getExtensionConfig(SymotionControllerAutowireBundle::ALIAS);
            $configs = $processor->processConfiguration(new Configuration(), $configs);

            $this->resolvedConfiguration = $containerBuilder->getParameterBag()->resolveValue($configs);
        }

        return $this->resolvedConfiguration;
    }
}
