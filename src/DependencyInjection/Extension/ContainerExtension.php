<?php declare(strict_types=1);

namespace TomasVotruba\SymfonyLegacyControllerAutowire\DependencyInjection\Extension;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use TomasVotruba\SymfonyLegacyControllerAutowire\SymplifyControllerAutowireBundle;

final class ContainerExtension extends Extension
{
    public function getAlias(): string
    {
        return SymplifyControllerAutowireBundle::ALIAS;
    }

    /**
     * @param mixed[] $config
     */
    public function load(array $config, ContainerBuilder $containerBuilder): void
    {
    }
}
