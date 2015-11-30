<?php

namespace Zenify\ControllerAutowire\Tests\HttpKernel\ControllerFinderSource;

class SomeController
{
    /**
     * @var SomeService
     */
    private $someService;

    public function __construct(SomeService $someService)
    {
        $this->someService = $someService;
    }

    /**
     * @return SomeService
     */
    public function getSomeService()
    {
        return $this->someService;
    }
}
