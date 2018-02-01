<?php

/**
 * CodeMommy RoutePHP
 * @author Candison November <www.kandisheng.com>
 */

declare(strict_types=1);

namespace CodeMommy\RoutePHP\Test;

use CodeMommy\RoutePHP\Route;
use CodeMommy\RoutePHP\RouteType;
use CodeMommy\RoutePHP\RouteMethod;

/**
 * Class RouteTest
 * @package CodeMommy\RoutePHP\Test
 */
class RouteTest extends BaseTest
{
    /**
     * RouteTest constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Test Construct
     */
    public function testConstruct()
    {
        new Route();
        $this->assertTrue(true);
    }

    /**
     * Test Normal
     */
    public function testNormal()
    {
        $_REQUEST['action'] = 'Test.normal';
        $route = new Route();
        $route->setNamespaceRoot('\\Controller');
        $route->setType(RouteType::NORMAL);
        $route->start();
        $this->expectOutputString('normal');
    }

    /**
     * Test PathInfo
     */
    public function testPathInfo()
    {
        $name = strval(rand(1, 100));
        $_SERVER['REQUEST_URI'] = sprintf('/test/pathinfo/name/%s', $name);
        $route = new Route();
        $route->setNamespaceRoot('\\Controller');
        $route->setType(RouteType::PATHINFO);
        $route->start();
        $this->expectOutputString($name);
    }

    /**
     * Test Map
     */
    public function testMap()
    {
        $_SERVER['REQUEST_URI'] = '/test/map';
        $route = new Route();
        $route->setNamespaceRoot('\\Controller');
        $route->setType(RouteType::MAP);
        $route->addRule('test/map', 'Test.map', RouteMethod::ANY);
        $route->start();
        $this->expectOutputString('map');
    }

    /**
     * Test Map Empty
     */
    public function testMapEmpty()
    {
        $_SERVER['REQUEST_URI'] = '/test/mapEmpty';
        $route = new Route();
        $route->setNamespaceRoot('\\Controller');
        $route->setType(RouteType::MAP);
        $route->addRule('test/map', 'Test.map', RouteMethod::ANY);
        $route->start();
        $this->expectOutputString('');
    }

    /**
     * Test No Namespace Root
     */
    public function testNoNamespaceRoot()
    {
        $_SERVER['REQUEST_URI'] = '/test/map';
        $route = new Route();
        $route->setNamespaceRoot('');
        $route->setType(RouteType::MAP);
        $route->addRule('test/map', 'ControllerNoNamespaceRoot.TestNoNamespaceRoot.map', RouteMethod::ANY);
        $route->start();
        $this->expectOutputString('map');
    }

    /**
     * Test Symfony
     */
    public function testSymfony()
    {
        $name = strval(rand(1, 100));
        $_SERVER['REQUEST_URI'] = sprintf('/test/symfony/%s', $name);
        $route = new Route();
        $route->setNamespaceRoot('\\Controller');
        $route->setType(RouteType::SYMFONY);
        $route->addRule('test/symfony/{name}', 'Test.symfony', RouteMethod::ANY);
        $route->start();
        $this->expectOutputString($name);
    }

    /**
     * Test Symfony Namespace
     */
    public function testSymfonyNamespace()
    {
        $_SERVER['REQUEST_URI'] = '/test/home';
        $route = new Route();
        $route->setNamespaceRoot('\\Controller\\');
        $route->setType(RouteType::SYMFONY);
        $route->addRule('test/home', 'Home.Home.index', RouteMethod::ANY);
        $route->start();
        $this->expectOutputString('index');
    }
}
