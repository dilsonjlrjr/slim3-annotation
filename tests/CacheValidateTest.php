<?php

namespace Test;


use Slim3\Annotation\CacheAnnotation;
use Slim3\Annotation\CollectorRoute;
use Slim3\Annotation\Slim3Annotation;

class CacheValidateTest extends BaseUnitTests {

    public $pathDirectoryController = __DIR__ . '/Controller';
    public $pathDirectoryCache = __DIR__ . '/cache/slim3-annotation/Cache';


    /**
     * @test
     */
    public function shouldGetAllFilesController() {

        $collector = new CollectorRoute();
        $arrayCollector = $collector->getControllers($this->pathDirectoryController);
        $arrayRouteModel = $collector->castRoute($arrayCollector);

        $this->assertEquals(count($arrayCollector), 2);
        foreach ($arrayCollector as $itemArray) {

            $this->assertTrue(is_string($itemArray[0]));
            $this->assertTrue(date($itemArray[1]) != false);

        }
        return [ $arrayCollector, $arrayRouteModel ];

    }

    /**
     * @param array $returnedArray
     * @test
     * @depends shouldGetAllFilesController
     */
    public function shouldValidateCache(array $returnedArray) {
        Slim3Annotation::createAutoloadCache($this->pathDirectoryCache);

        $validate = new CacheAnnotation($this->pathDirectoryCache, $this->_app);
        $this->assertTrue($validate->updatedCache($returnedArray[0], $returnedArray[1]));
    }

    /**
     * @test
     * @depends shouldGetAllFilesController
     */
    public function shouldWriteCache() {
        Slim3Annotation::createAutoloadCache($this->pathDirectoryCache);
        $collector = new CollectorRoute();
        $arrayCollector = $collector->getControllers($this->pathDirectoryController);
        $arrayModelControllers = $collector->castRoute($arrayCollector);

        $validate = new CacheAnnotation($this->pathDirectoryCache, $this->_app);
        $this->assertTrue($validate->write($arrayModelControllers));
    }

    /**
     * @test
     * @depends shouldGetAllFilesController
     */
    public function shouldLoadLastCache() {
        Slim3Annotation::createAutoloadCache($this->pathDirectoryCache);

        $validate = new CacheAnnotation($this->pathDirectoryCache, $this->_app);
        $lastCache = $validate->loadLastCache();

        $lastCache = str_replace("Cache\\", "", $lastCache);
        $file = str_replace("\\", DIRECTORY_SEPARATOR, $this->pathDirectoryCache . DIRECTORY_SEPARATOR . $lastCache . '.php');
        unlink($file);

        $response = $this->runRoute('GET', '/prefix3/rota2');
        $this->assertEquals(200, $response->getStatusCode());
    }

}