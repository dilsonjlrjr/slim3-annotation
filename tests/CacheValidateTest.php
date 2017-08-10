<?php

namespace Test;


use Slim3\Annotation\CacheAnnotation;
use Slim3\Annotation\CollectorRoute;

class CacheValidateTest extends BaseUnitTests {

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
     * @return array
     */
    public function shouldValidateCache(array $arrayCollector) {
        $validate = new CacheAnnotation($this->pathDirectoryCache, $this->_app);
        $this->assertTrue($validate->updatedCache($arrayCollector));

        return $arrayCollector;
    }

    /**
     * @test
     * @depends shouldGetAllFilesController
     *
     * @param array $arrayCollector
     */
    public function shouldWriteCache(array $arrayCollector) {
        $collector = new CollectorRoute();
        $arrayModelControllers = $collector->castRoute($arrayCollector);

        $validate = new CacheAnnotation($this->pathDirectoryCache, $this->_app);
        $this->assertTrue($validate->write($arrayModelControllers));
    }

    /**
     * @test
     * @depends shouldGetAllFilesController
     */
    public function shouldLoadLastCache() {
        $validate = new CacheAnnotation($this->pathDirectoryCache, $this->_app);
        $lastCache = $validate->loadLastCache();

        unlink($lastCache);

        $response = $this->runRoute('GET', '/prefix3/rota2');
        $this->assertEquals(200, $response->getStatusCode());
    }

}