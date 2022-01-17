<?php

declare(strict_types=1);

namespace TomasVotruba\SymfonyLegacyControllerAutowire;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use TomasVotruba\SymfonyLegacyControllerAutowire\DependencyInjection\Compiler\AutowireControllerDependenciesPass;
use TomasVotruba\SymfonyLegacyControllerAutowire\DependencyInjection\Compiler\DecorateControllerResolverPass;
use TomasVotruba\SymfonyLegacyControllerAutowire\DependencyInjection\Compiler\RegisterControllersPass;
use TomasVotruba\SymfonyLegacyControllerAutowire\DependencyInjection\ControllerClassMap;
use TomasVotruba\SymfonyLegacyControllerAutowire\DependencyInjection\Extension\ContainerExtension;
use TomasVotruba\SymfonyLegacyControllerAutowire\HttpKernel\Controller\ControllerFinder;

final class SymplifyControllerAutowireBundle extends Bundle
{
    /**
     * @var string
     */
    public const ALIAS = 'symplify_controller_autowire';

    public function build(ContainerBuilder $containerBuilder): void
    {
        $controllerClassMap = new ControllerClassMap();

        $containerBuilder->addCompilerPass(new RegisterControllersPass($controllerClassMap, new ControllerFinder()));
        $containerBuilder->addCompilerPass(new AutowireControllerDependenciesPass($controllerClassMap));
        $containerBuilder->addCompilerPass(new DecorateControllerResolverPass($controllerClassMap));
    }

    public function createContainerExtension(): ContainerExtension
    {
        return new ContainerExtension();
    }
}
