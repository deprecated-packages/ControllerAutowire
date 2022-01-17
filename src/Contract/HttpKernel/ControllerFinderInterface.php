<?php declare(strict_types=1);

namespace TomasVotruba\SymfonyLegacyControllerAutowire\Contract\HttpKernel;

interface ControllerFinderInterface
{
    /**
     * @param string[] $dirs
     *
     * @return string[]
     */
    public function findControllersInDirs(array $dirs): array;
}
