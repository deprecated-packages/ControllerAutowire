<?php declare(strict_types=1);

namespace TomasVotruba\SymfonyLegacyControllerAutowire\Contract\HttpKernel;

interface ControllerClassMapAwareInterface
{
    /**
     * @param string[] $controllerClassMap
     */
    public function setControllerClassMap(array $controllerClassMap): void;
}
