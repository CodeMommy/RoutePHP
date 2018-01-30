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
     * Set Config
     * @param array $config
     * @return bool
     */
    public function setConfig($config = array());
    
    /**
     * Set Namespace Root
     * @param string $namespaceRoot
     * @return bool
     */
    public function setNamespaceRoot($namespaceRoot = '\\');

    /**
     * Start
     * @return mixed
     */
    public function start();
}
