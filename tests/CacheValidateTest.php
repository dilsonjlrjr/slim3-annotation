<?php

namespace Test;


use Slim3\Annotation\CacheAnnotation;
use Slim3\Annotation\CollectorRoute;

class CacheValidateTest extends \PHPUnit_Framework_TestCase
{

    public $pathDirectoryController = __DIR__ . '/Controller';
    public $pathDirectoryCache = __DIR__ . '/cache/slim3-annotation/';

    /**
     * @test
     */
    public function shouldGetAllFilesController() {

        $collector = new CollectorRoute();
        $arrayCollector = $collector->getControllers($this->pathDirectoryController);

        $this->assertEquals(count($arrayCollector), 2);
        foreach ($arrayCollector as $itemArray) {

            $this->assertTrue(is_string($itemArray[0]));
            $this->assertTrue(date($itemArray[1]) != false);

        }

        return $arrayCollector;

    }

    /**
     * @param array $arrayCollector
     * @test
     * @depends shouldGetAllFilesController
     */
    public function shouldValidateCache(array $arrayCollector) {

        $validate = new CacheAnnotation($this->pathDirectoryCache);

        $this->assertTrue($validate->updatedCache($arrayCollector));
    }

    /**
     * @test
     * @depends shouldGetAllFilesController
     */
    public function shouldValidateCacheWithoutController() {
        $validate = new CacheAnnotation($this->pathDirectoryCache);
        $this->assertTrue(!$validate->updatedCache([]));
    }

}