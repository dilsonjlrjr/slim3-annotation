<?php

namespace Test;


use Slim3\Annotation\CollectorRoute;
use Test\BaseUnitTests;

class RouteCollectorTest extends BaseUnitTests
{

    public $pathDirectoryController = __DIR__ . '/Controller';

    /**
     * @test
     */
    public function shouldParseRoute() {

        $collector = new CollectorRoute();
        $arrayRoute = $collector->getControllers($this->pathDirectoryController);

        $arrayRouteObject = $collector->castRoute($arrayRoute);

        $this->assertCount(5, $arrayRouteObject);

    }

}