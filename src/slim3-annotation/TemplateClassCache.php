<?php

namespace Cache;

class {{SLIM3-ANNOTATION-CLASSNAME}}
{
    public function __invoke(\Slim\App $app) {
        {{SLIM3-CONTENT}}
    }

    public function getArrayControllersSerialize() {
        return '{{ARRAY-CONTROLLERS}}';
    }
}