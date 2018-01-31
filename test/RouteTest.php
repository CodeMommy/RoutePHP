<?php

/**
 * CodeMommy RoutePHP
 * @author Candison November <www.kandisheng.com>
 */

declare(strict_types=1);

namespace Test;

use PHPUnit\Framework\TestCase;
use CodeMommy\RoutePHP\Route;
use CodeMommy\RoutePHP\RouteType;

/**
 * Class RouteTest
 * @package Test
 */
class RouteTest extends TestCase
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
        $route->addRule('any', 'test/map', 'Test.map');
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
        $route->addRule('any', 'test/map', 'Test.map');
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
        $route->addRule('any', 'test/map', 'ControllerNoNamespaceRoot.TestNoNamespaceRoot.map');
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
        $route->addRule('any', 'test/symfony/{name}', 'Test.symfony');
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
        $route->addRule('any', 'test/home', 'Home.Home.index');
        $route->start();
        $this->expectOutputString('index');
    }
}
