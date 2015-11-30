<?php

/*
 * This file is part of Zenify
 * Copyright (c) 2015 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Zenify\ControllerAutowire\Config\Definition;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Zenify\ControllerAutowire\ZenifyControllerAutowireBundle;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root(ZenifyControllerAutowireBundle::ALIAS);

        $rootNode->children()
            ->arrayNode('controller_dirs')
                ->defaultValue(['%kernel.root_dir%', '%kernel.root_dir%/../src'])
                    ->prototype('scalar')
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
