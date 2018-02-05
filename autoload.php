<?php

/**
 * CodeMommy RoutePHP
 * @author Candison November <www.kandisheng.com>
 */

require_once('library/Autoload.php');

use CodeMommy\RoutePHP\Library\Autoload;

$autoloaDirectory = array(
    'library' => 'CodeMommy\\RoutePHP\\Library',
    'class' => 'CodeMommy\\RoutePHP',
    'interface' => 'CodeMommy\\RoutePHP'
);

Autoload::directory($autoloaDirectory);
