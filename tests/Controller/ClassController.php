<?php

namespace Test\Controller;

/**
 * Class ClassModel
 * @package Test\Reflection
 *
 *
 * @Route("/prefix")
 */
class ClassController
{

    /**
     * @Get(name="/rota2/{id}", alias="rote.id")
     */
    public function method() {
    }

    /**
     * @Any(name="/rota2/{id}", alias="route2.id")
     */
    public function method2() {
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