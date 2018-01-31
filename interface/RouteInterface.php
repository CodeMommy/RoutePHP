<?php

/**
 * CodeMommy RoutePHP
 * @author Candison November <www.kandisheng.com>
 */

namespace CodeMommy\RoutePHP;

/**
 * Interface RouteInterface
 * @package CodeMommy\RoutePHP
 */
interface RouteInterface
{
    /**
     * RouteInterface constructor.
     */
    public function __construct();

    /**
     * Set Namespace Root
     * @param string $namespaceRoot
     * @return bool
     */
    public function setNamespaceRoot($namespaceRoot = '\\');

    /**
     * Set Type
     * @param string $type
     */
    public function setType($type = '');

    /**
     * Add Rule
     * @param string $method
     * @param string $rule
     * @param string $action
     */
    public function addRule($method = '', $rule = '', $action = '');

    /**
     * Start
     * @return mixed
     */
    public function start();
}
