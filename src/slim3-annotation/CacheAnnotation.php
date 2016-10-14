<?php

namespace Slim3\Annotation;


class CacheAnnotation
{

    private $pathCache;


    /**
     * CacheSlimAnnotation constructor.
     *
     * @param string $pathCache
     */
    public function __construct(string $pathCache)
    {
        $this->pathCache = $pathCache;
    }

    public function write(string $pathCache, array $arrayRouteModel) {



    }

    public function updatedCache(array $controlerArray) : bool {

        uasort($controlerArray, [CacheAnnotation::class, "orderArrayByDateModified"]);

        $directory = new \RecursiveDirectoryIterator($this->pathCache);
        $regexDirectory = new \RecursiveRegexIterator($directory, '/cache(\d*)\.php/', \RecursiveRegexIterator::GET_MATCH);

        $arrayDirectoryRegex = [];
        foreach ($regexDirectory as $item) {
            $arrayDirectoryRegex[] = $item;
        }

        uasort($arrayDirectoryRegex, [CacheAnnotation::class, "orderArrayByDateModified"]);

        $firstControllerArray = array_shift($controlerArray);
        $firstDirectoryRegex = array_shift($arrayDirectoryRegex);

        if ($firstControllerArray[1] < $firstDirectoryRegex[1])
            return false;

        return true;
    }

    private function orderArrayByDateModified(array $elementA, array $elementB) {
        if ($elementA == $elementB) {
            return 0;
        }
        return ($elementA[1] > $elementB[1]) ? -1 : 1;
    }

}