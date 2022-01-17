<?php declare(strict_types=1);

namespace TomasVotruba\SymfonyLegacyControllerAutowire\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use TomasVotruba\SymfonyLegacyControllerAutowire\Contract\DependencyInjection\ControllerClassMapInterface;
use TomasVotruba\SymfonyLegacyControllerAutowire\Controller\ControllerTrait;
use TomasVotruba\SymfonyLegacyControllerAutowire\Controller\Doctrine\ControllerDoctrineTrait;
use TomasVotruba\SymfonyLegacyControllerAutowire\Controller\Form\ControllerFormTrait;
use TomasVotruba\SymfonyLegacyControllerAutowire\Controller\HttpKernel\ControllerHttpKernelTrait;
use TomasVotruba\SymfonyLegacyControllerAutowire\Controller\Routing\ControllerRoutingTrait;
use TomasVotruba\SymfonyLegacyControllerAutowire\Controller\Security\ControllerSecurityTrait;
use TomasVotruba\SymfonyLegacyControllerAutowire\Controller\Serializer\ControllerSerializerTrait;
use TomasVotruba\SymfonyLegacyControllerAutowire\Controller\Session\ControllerFlashTrait;
use TomasVotruba\SymfonyLegacyControllerAutowire\Controller\Templating\ControllerRenderTrait;

final class AutowireControllerDependenciesPass implements CompilerPassInterface
{
    /**
     * @var ControllerClassMapInterface
     */
    private $controllerClassMap;

    /**
     * @var ContainerBuilder
     */
    private $containerBuilder;

    /**
     * @var string[][]
     */
    private $traitsToSettersToServiceNameList = [
        ControllerFlashTrait::class => [
            'setSession' => 'session',
        ],
        ControllerDoctrineTrait::class => [
            'setDoctrine' => 'doctrine',
        ],
        ControllerRoutingTrait::class => [
            'setRouter' => 'router',
        ],
        ControllerHttpKernelTrait::class => [
            'setHttpKernel' => 'http_kernel',
            'setRequestStack' => 'request_stack',
        ],
        ControllerSerializerTrait::class => [
            'setSerializer' => 'serializer',
        ],
        ControllerSecurityTrait::class => [
            'setAuthorizationChecker' => 'security.authorization_checker',
            'setTokenStorage' => 'security.token_storage',
            'setCsrfTokenManager' => 'security.csrf.token_manager',
        ],
        ControllerRenderTrait::class => [
            'setTemplating' => 'templating',
            'setTwig' => 'twig',
        ],
        ControllerFormTrait::class => [
            'setFormFactory' => 'form.factory',
        ],
    ];

    public function __construct(ControllerClassMapInterface $controllerClassMap)
    {
        $this->controllerClassMap = $controllerClassMap;
    }

    public function process(ContainerBuilder $containerBuilder): void
    {
        $this->containerBuilder = $containerBuilder;

        foreach ($this->controllerClassMap->getControllers() as $serviceId => $className) {
            $controllerDefinition = $containerBuilder->getDefinition($serviceId);
            $this->autowireControllerTraits($controllerDefinition);
        }
    }

    private function autowireControllerTraits(Definition $controllerDefinition): void
    {
        $usedTraits = class_uses($controllerDefinition->getClass());

        foreach ($this->traitsToSettersToServiceNameList as $traitClass => $setterToServiceNames) {
            if (! $this->isTraitIncluded($traitClass, $usedTraits)) {
                continue;
            }

            $this->setTraitDependencies($controllerDefinition, $setterToServiceNames);
        }
    }

    /**
     * @param string[] $usedTraits
     */
    private function isTraitIncluded(string $traitClass, array $usedTraits): bool
    {
        if (array_key_exists($traitClass, $usedTraits)) {
            return true;
        }

        if (isset($usedTraits[ControllerTrait::class])) {
            return true;
        }

        return false;
    }

    /**
     * @param string[] $setterToServiceNames
     */
    private function setTraitDependencies(Definition $controllerDefinition, array $setterToServiceNames): void
    {
        foreach ($setterToServiceNames as $setter => $serviceName) {
            if (! $this->containerBuilder->has($serviceName)) {
                continue;
            }

            $controllerDefinition->addMethodCall($setter, [new Reference($serviceName)]);
        }
    }
}
