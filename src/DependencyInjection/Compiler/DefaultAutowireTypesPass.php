<?php

/*
 * This file is part of Zenify
 * Copyright (c) 2015 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Zenify\ControllerAutowire\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

final class DefaultAutowireTypesPass implements CompilerPassInterface
{
    /**
     * @todo make configurable?
     *
     * @var string[] Service name => autowired type
     */
    private $preferedAutowireTypes = [
        'doctrine.orm.default_entity_manager' => 'Doctrine\ORM\EntityManagerInterface',
    ];

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $containerBuilder)
    {
        foreach ($this->preferedAutowireTypes as $serviceName => $type) {
            if (!$containerBuilder->has($serviceName)) {
                continue;
            }

            if ($containerBuilder->hasAlias($serviceName)) {
                $serviceName = $containerBuilder->getAlias($serviceName);
            }

            $containerBuilder->getDefinition($serviceName)
                ->setAutowiringTypes([$type]);
        }
    }
}
