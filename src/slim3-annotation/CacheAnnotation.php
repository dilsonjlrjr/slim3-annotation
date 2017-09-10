<?php

namespace Slim3\Annotation;


use Slim\App;
use Cache;

class CacheAnnotation
{

    private $pathCache;

    /**
     * @var App
     */
    private $application;


    /**
     * CacheSlimAnnotation constructor.
     *
     * @param string $pathCache
     * @param App $app
     */
    public function __construct(string $pathCache, App $app)
    {
        $this->pathCache = $pathCache;
        $this->application = $app;
    }

    public function write(array $arrayRouteModel) {

        $dateNow = new \DateTime('now');
        $namefile = 'cache' . $dateNow->format('YmdHis');
        $templateClass = file_get_contents(__DIR__ . '/TemplateClassCache.php');

        $templateClass = str_replace('{{SLIM3-ANNOTATION-CLASSNAME}}', $namefile, $templateClass);

        $content = "";

        foreach ($arrayRouteModel as $routeModel) {

            $content .= '$route = $app->map(["' . $routeModel->getVerb(). '"], "' . $routeModel->getRoute() . '", "' . $routeModel->getClassName() . ':' . $routeModel->getMethodName() . '");' . PHP_EOL;

            if ($routeModel->getAlias() != null) {
                $content .= '$route->setName("' . $routeModel->getAlias() . '");' . PHP_EOL;
            }

            if ($routeModel->getClassMiddleware() != null) {
                $classMiddleware = $routeModel->getClassMiddleware();
                foreach ($classMiddleware as $middleware) {
                    $content .= '$route->add(new \\' . $middleware . '());' . PHP_EOL;
                }
            }
        }

        $templateClass = str_replace('{{SLIM3-CONTENT}}', $content, $templateClass);
        $templateClass = str_replace('{{ARRAY-CONTROLLERS}}', serialize($arrayRouteModel), $templateClass);


        file_put_contents($this->pathCache . '/' . $namefile . '.php', $templateClass);

        return true;
    }

    /**
     * @param array $controlerArray
     * @return bool
     * TODO Refactor chegar a
     */
    public function updatedCache(array $controlerArray, array $arrayRouteObject) : bool {

        uasort($controlerArray, [CacheAnnotation::class, "orderArrayByDateModified"]);

        $directory = new \RecursiveDirectoryIterator($this->pathCache);
        $regexDirectory = new \RecursiveRegexIterator($directory, '/cache(\d*)\.php/', \RecursiveRegexIterator::GET_MATCH);

        $arrayDirectoryRegex = [];
        foreach ($regexDirectory as $item) {
            $arrayDirectoryRegex[] = [
                $item,
                filemtime($this->pathCache . DIRECTORY_SEPARATOR . $item[0])
            ];
        }



        if (count($arrayDirectoryRegex) == 0)
            return false;


        if (serialize($arrayRouteObject) !== $this->validateControllerExcluded())
            return false;

        uasort($arrayDirectoryRegex, [CacheAnnotation::class, "orderArrayByDateModified"]);

        $firstControllerArray = array_shift($controlerArray);
        $firstDirectoryRegex = array_shift($arrayDirectoryRegex);

        if ($firstControllerArray[1] > $firstDirectoryRegex[1])
            return false;

        return true;
    }

    private function orderArrayByDateModified(array $elementA, array $elementB) {
        if ($elementA == $elementB) {
            return 0;
        }
        return ($elementA[1] > $elementB[1]) ? -1 : 1;
    }

    private function loadClassLastCache() {
        $directory = new \RecursiveDirectoryIterator($this->pathCache);
        $regexDirectory = new \RecursiveRegexIterator($directory, '/cache(\d*)\.php/', \RecursiveRegexIterator::GET_MATCH);

        $arrayDirectoryRegex = [];
        foreach ($regexDirectory as $item) {
            $arrayDirectoryRegex[] = $item;
        }

        uasort($arrayDirectoryRegex, [CacheAnnotation::class, "orderArrayByDateModified"]);
        $firstDirectoryRegex = array_shift($arrayDirectoryRegex);

        $classCache = "Cache\\" . substr($firstDirectoryRegex[0], 0, strlen($firstDirectoryRegex[0]) - 4);

        return $classCache;
    }

    public function loadLastCache() {

        $classCache = $this->loadClassLastCache();

        $classCacheConcret  = new $classCache();
        $classCacheConcret($this->application);

        return $classCache;
    }

    public function validateControllerExcluded() {
        $classCache = $this->loadClassLastCache();

        $classCacheConcret  = new $classCache();
        return $classCacheConcret->getArrayControllersSerialize();
    }

}