<?php

namespace Tests1Doc;

use Illuminate\Container\Container;
use Tests1Doc\AdvancedTests;

class ContainerTest
{
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function usingAdvancedTests()
    {
        $advancedTests = $this->container->make(AdvancedTests::class);
        return $advancedTests->biricutidoDay();
    }

    public function leoAge()
    {
        $advancedTests = $this->container->make(AdvancedTests::class);
        return $advancedTests->returnAge('1760','08','12');
    }
}
