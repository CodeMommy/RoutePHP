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
class RouteMethod implements RouteMethodInterface
{
    const ANY = 'any';
    const OPTIONS = 'options';
    const HEAD = 'head';
    const GET = 'get';
    const POST = 'post';
    const PUT = 'put';
    const DELETE = 'delete';
    const TRACE = 'trace';
    const CONNECT = 'connect';
}
