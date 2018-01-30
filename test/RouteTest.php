<?php

/**
 * CodeMommy RoutePHP
 * @author Candison November <www.kandisheng.com>
 */

declare(strict_types=1);

namespace Test;

use PHPUnit\Framework\TestCase;
use CodeMommy\RoutePHP\Route;

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
     * Test Start Map
     */
    public function testStartMap()
    {
        $_SERVER['REQUEST_URI'] = '/test/map';
        $route = new Route();
        $route->setNamespaceRoot('\\Controller');
        $route->setConfig(array(
            'type' => 'map',
            'any' => array(
                'test/map' => 'Test.map'
            )
        ));
        $route->start();
        $this->expectOutputString('map');
    }

    /**
     * Test Start Map Empty
     */
    public function testStartMapEmpty()
    {
        $_SERVER['REQUEST_URI'] = '/test/mapEmpty';
        $route = new Route();
        $route->setNamespaceRoot('\\Controller');
        $route->setConfig(array(
            'type' => 'map',
            'any' => array(
                'test/map' => 'Test.map'
            )
        ));
        $route->start();
        $this->expectOutputString('');
    }

    /**
     * Test Start PathInfo
     */
    public function testStartPathInfo()
    {
        $name = 'pathinfo';
        $_SERVER['REQUEST_URI'] = sprintf('/test/pathinfo/name/%s', $name);
        $route = new Route();
        $route->setNamespaceRoot('\\Controller');
        $route->setConfig(array(
            'type' => 'pathinfo'
        ));
        $route->start();
        $this->expectOutputString($name);
    }

    /**
     * Test Start Symfony
     */
    public function testStartSymfony()
    {
        $name = 'symfony';
        $_SERVER['REQUEST_URI'] = sprintf('/test/symfony/%s', $name);
        $route = new Route();
        $route->setNamespaceRoot('\\Controller');
        $route->setConfig(array(
            'type' => 'symfony',
            'any' => array(
                'test/symfony/{name}' => 'Test.symfony',
            )
        ));
        $route->start();
        $this->expectOutputString($name);
    }

    /**
     * Test Start Symfony Namespace
     */
    public function testStartSymfonyNamespace()
    {
        $_SERVER['REQUEST_URI'] = '/test/home';
        $route = new Route();
        $route->setNamespaceRoot('\\Controller\\');
        $route->setConfig(array(
            'type' => 'symfony',
            'any' => array(
                'test/home' => 'Home.Home.index'
            )
        ));
        $route->start();
        $this->expectOutputString('index');
    }
}
