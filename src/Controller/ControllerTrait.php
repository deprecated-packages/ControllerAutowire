<?php declare(strict_types=1);

namespace TomasVotruba\SymfonyLegacyControllerAutowire\Controller;

use TomasVotruba\SymfonyLegacyControllerAutowire\Controller\Doctrine\ControllerDoctrineTrait;
use TomasVotruba\SymfonyLegacyControllerAutowire\Controller\Form\ControllerFormTrait;
use TomasVotruba\SymfonyLegacyControllerAutowire\Controller\HttpKernel\ControllerHttpKernelTrait;
use TomasVotruba\SymfonyLegacyControllerAutowire\Controller\Routing\ControllerRoutingTrait;
use TomasVotruba\SymfonyLegacyControllerAutowire\Controller\Security\ControllerSecurityTrait;
use TomasVotruba\SymfonyLegacyControllerAutowire\Controller\Serializer\ControllerSerializerTrait;
use TomasVotruba\SymfonyLegacyControllerAutowire\Controller\Session\ControllerFlashTrait;
use TomasVotruba\SymfonyLegacyControllerAutowire\Controller\Templating\ControllerRenderTrait;

trait ControllerTrait
{
    use ControllerDoctrineTrait;
    use ControllerFlashTrait;
    use ControllerFormTrait;
    use ControllerHttpKernelTrait;
    use ControllerRoutingTrait;
    use ControllerRenderTrait;
    use ControllerSecurityTrait;
    use ControllerSerializerTrait;
}
