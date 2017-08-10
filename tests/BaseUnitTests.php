<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class BaseTests
 */
class BaseUnitTests extends TestCase
{

    /**
     * @var \Interop\Container\ContainerInterface
     */
    protected $_ci;

    /**
     * @var Slim\App
     */
    protected $_app;

    /**
     * Setup Tests
     */
    public function setUp()
    {
        @session_start();
        $this->createApplication();
    }

    /**
     * Create Application
     *
     * @return bool
     */
    private function createApplication() {

        // Instantiate the app
        $settings = [
            'settings' => [
                // Slim Settings
                'determineRouteBeforeAppMiddleware' => true,
                'displayErrorDetails' => true,
            ]
        ];
        $app = new \Slim\App($settings);

        $container = $app->getContainer();

        $this->_app = $app;
        $this->_ci = $app->getContainer();

        return TRUE;
    }

    /**
     * Process the application given a request method and URI
     *
     * @param string $requestMethod the request method (e.g. GET, POST, etc.)
     * @param string $requestUri the request URI
     * @param array|object|null $requestData the request data
     * @return \Slim\Http\Response
     */
    public function runRoute($requestMethod, $requestUri, $requestData = null)
    {
        // Create a mock environment for testing with
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' => $requestMethod,
                'REQUEST_URI' => $requestUri
            ]
        );

        // Set up a request object based on the environment
        $request = Request::createFromEnvironment($environment);

        // Add request data, if it exists
        if (isset($requestData)) {
            $request = $request->withParsedBody($requestData);
        }

        // Set up a response object
        $response = new Response();


        // Process the application
        $response = $this->_app->process($request, $response);

        // Return the response
        return $response;
    }
}