<?php declare(strict_types=1);

namespace TomasVotruba\SymfonyLegacyControllerAutowire\Controller\Doctrine;

use Doctrine\Common\Persistence\ManagerRegistry;

trait ControllerDoctrineTrait
{
    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    public function setDoctrine(ManagerRegistry $doctrine): void
    {
        $this->doctrine = $doctrine;
    }

    protected function getDoctrine(): ManagerRegistry
    {
        return $this->doctrine;
    }
}
