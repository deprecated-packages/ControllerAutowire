<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\ControllerAutowire\DependencyInjection;

use Doctrine\Bundle\DoctrineBundle\Registry;
use LogicException;

trait DoctrineAwareTrait
{

    /**
     * @var Registry
     */
    protected $doctrineRegistry;


    /**
     * @param Registry $doctrineRegistry
     */
    public function setDoctrineRegistry(Registry $doctrineRegistry)
    {
        $this->doctrineRegistry = $doctrineRegistry;
    }

    /**
     * Shortcut to return the Doctrine EntityManager
     *
     * @return Registry
     *
     * @throws LogicException If DoctrineBundle is not available
     */
    protected function getDoctrine() : Registry
    {
        if (is_null($this->doctrineRegistry)) {
            throw new LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->doctrineRegistry;
    }
}
