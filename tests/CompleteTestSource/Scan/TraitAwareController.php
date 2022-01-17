<?php

declare(strict_types=1);

namespace TomasVotruba\SymfonyLegacyControllerAutowire\Tests\CompleteTestSource\Scan;

use TomasVotruba\SymfonyLegacyControllerAutowire\Controller\ControllerTrait;

final class TraitAwareController
{
    use ControllerTrait;

    public function someAction(): void
    {
    }
}
