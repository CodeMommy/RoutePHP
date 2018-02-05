<?php

/**
 * CodeMommy RoutePHP
 * @author Candison November <www.kandisheng.com>
 */

namespace CodeMommy\RoutePHP;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route as Routes;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Route
 * @package CodeMommy\RoutePHP
 */
class Route implements RouteInterface
{
    /**
     * Namespace Root
     * @var string
     */
    private $namespaceRoot = '\\';

    /**
     * Type
     * @var string
     */
    private $type = 'normal';

    /**
     * Rule
     * @var array
     */
    private $rule = array();

    /**
     * Route constructor.
     */
    public function __construct()
    {
        return true;
    }

    /**
     * Set Namespace Root
     * @param string $namespaceRoot
     * @return bool
     */
    public function setNamespaceRoot($namespaceRoot = '\\')
    {
        $namespaceRoot = trim($namespaceRoot, '/\\');
        if (empty($namespaceRoot)) {
            $this->namespaceRoot = '\\';
            return true;
        }
        $this->namespaceRoot = sprintf('\\%s\\', $namespaceRoot);
        return true;
    }

    /**
     * Set Type
     * @param string $type
     * @return bool
     */
    public function setType($type = '')
    {
        $this->type = empty($type) ? RouteType::NORMAL : $type;
        return true;
    }

    /**
     * Get Type
     * @return string
     */
    private function getType()
    {
        return empty($this->type) ? RouteType::NORMAL : $this->type;
    }

    /**
     * Add Rule
     * @param string $rule
     * @param string $action
     * @param string $method
     * @return bool
     */
    public function addRule($rule = '', $action = '', $method = RouteMethod::ANY)
    {
        $method = empty($method) ? RouteMethod::ANY : strtolower($method);
        if (!isset($this->rule[$method])) {
            $this->rule[$method] = array();
        }
        $this->rule[$method][$rule] = $action;
        return true;
    }

    /**
     * Get Route
     * @return array
     */
    private function getRule()
    {
        $requestMethod = isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD']) : '';
        $routeRuleCustom = isset($this->rule[$requestMethod]) ? $this->rule[$requestMethod] : array();
        $routeRuleAny = isset($this->rule[RouteMethod::ANY]) ? $this->rule[RouteMethod::ANY] : array();
        $routeRule = array_merge($routeRuleAny, $routeRuleCustom);
        return $routeRule;
    }

    /**
     * Render
     * @param string $route
     * @return bool
     */
    private function render($route = '')
    {
        if (empty($route)) {
            return false;
        }
        $path = explode('.', $route);
        $actionName = array_pop($path);
        $controllerName = array_pop($path);
        $namespace = implode('\\', $path);
        if (!empty($namespace)) {
            $namespace .= '\\';
        }
        $namespace = $this->namespaceRoot . $namespace . $controllerName;
        $class = new $namespace();
        $result = $class->$actionName();
        $type = gettype($result);
        $array = array('string', 'integer', 'double', 'boolean', 'array', 'object');
        if (in_array($type, $array)) {
            echo $result;
        }
        return true;
    }

    /**
     * Type Normal
     * @return bool
     */
    private function typeNormal()
    {
        $requestKey = 'action';
        $defaultRoute = 'Index.index';
        $route = isset($_REQUEST[$requestKey]) ? $_REQUEST[$requestKey] : $defaultRoute;
        return $this->render($route);
    }

    /**
     * Type Path Info
     * @return bool
     */
    private function typePathInfo()
    {
        $request = Request::createFromGlobals();
        $pathInfo = $request->getPathInfo();
        // Set Controller and Action
        $urlArray = explode('/', $pathInfo);
        $controllerName = 'index';
        if (!empty($urlArray[1])) {
            $controllerName = $urlArray[1];
        }
        $controllerName = ucfirst(strtolower($controllerName));
        $actionName = 'index';
        if (!empty($urlArray[2])) {
            $actionName = $urlArray[2];
        }
        // Parameter
        $urlList = array(0, 1, 2);
        foreach ($urlArray as $key => $value) {
            if (!in_array($key, $urlList)) {
                if ($key % 2 == 0) {
                    $_GET[$urlArray[$key - 1]] = empty($value) ? '' : $value;
                }
            }
        }
        $route = $controllerName . '.' . $actionName;
        return $this->render($route);
    }

    /**
     * Type Map
     * @return bool
     */
    private function typeMap()
    {
        $request = Request::createFromGlobals();
        $pathInfo = $request->getPathInfo();
        $pathInfo = trim($pathInfo, '/');
        $routeConfigure = $this->getRule();
        foreach ($routeConfigure as $key => $value) {
            if ($pathInfo == trim($key, '/')) {
                return $this->render($value);
            }
        }
        return $this->render('');
    }

    /**
     * Type Symfony
     * @return bool
     */
    private function typeSymfony()
    {
        $routeConfigure = $this->getRule();
        $routes = new RouteCollection();
        foreach ($routeConfigure as $key => $value) {
            $routes->add($key, new Routes($key));
        }
        $request = Request::createFromGlobals();
        $context = new RequestContext();
        $context->fromRequest($request);
        $matcher = new UrlMatcher($routes, $context);
        $pathInfo = $request->getPathInfo();
        $attributes = $matcher->match($pathInfo);
        foreach ($attributes as $key => $value) {
            if ($key != '_route') {
                $_GET[$key] = $value;
            }
        }
        $route = $attributes['_route'];
        $route = $routeConfigure[$route];
        return $this->render($route);
    }


    /**
     * Start
     * @return bool
     */
    public function start()
    {
        $routeType = $this->getType();
        if ($routeType == RouteType::NORMAL) {
            $this->typeNormal();
        }
        if ($routeType == RouteType::PATHINFO) {
            $this->typePathInfo();
        }
        if ($routeType == RouteType::MAP) {
            $this->typeMap();
        }
        if ($routeType == RouteType::SYMFONY) {
            $this->typeSymfony();
        }
        return true;
    }
}
