<?php

namespace Test\Controller;

/**
 * Class ClassModel
 * @package Test\Reflection
 *
 * @Controller
 * @Route("/prefix2")
 */
class ClassModel
{

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