<?php

namespace Test;


use Slim3\Annotation\CollectorRoute;

class RouteCollectorTest extends \PHPUnit_Framework_TestCase
{

    public $pathDirectoryController = __DIR__ . '/Controller';

    /**
     * @test
     */
    public function shouldParseRoute() {

        $collector = new CollectorRoute();
        $arrayRoute = $collector->getControllers($this->pathDirectoryController);

        $arrayRouteObject = $collector->convertModelRoute($arrayRoute);

        $this->assertCount(5, $arrayRouteObject);

    }

}