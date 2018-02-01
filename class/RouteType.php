<?php

/**
 * CodeMommy RoutePHP
 * @author Candison November <www.kandisheng.com>
 */

namespace CodeMommy\RoutePHP;

/**
 * Class RouteType
 * @package CodeMommy\RoutePHP
 */
class RouteType implements RouteTypeInterface
{
    const NORMAL = 'normal';
    const PATHINFO = 'pathinfo';
    const MAP = 'map';
    const SYMFONY = 'symfony';
}
