<?php

namespace Test\Controller;

/**
 * Class ClassModel
 * @package Test\Reflection
 *
 *
 * @Controller
 * @Route("/prefix")
 */
class DilsonController
{

    /**
     * @Get(name="/rota2", alias="rote.id")
     */
    public function method() {
        echo "Hedvan";
    }

    /**
     * @Get(name="/rota3/{id}/{id2}/[{idgenilson}]", alias="route2.id")
     */
    public function method2($request, $response, $args) {
        echo "Alisson";
        print_r($args);
    }

    /**
     * @Post(name="/rota3/{id}", alias="route3.id")
     */
    public function method3() {
    }

    /**
     * @Put(name="/rota4/{id}", alias="route4.id")
     */
    public function method4() {
    }

    /**
     * @Delete(name="/rota5/{id}", alias="route5.id")
     */
    public function method5() {
    }

    /**
     * Default Get
     * @Route(name="/rota6/{id}", )
     */
    public function method6() {
    }

}