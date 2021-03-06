<?php

/**
 * CodeMommy RoutePHP
 * @author Candison November <www.kandisheng.com>
 */

require_once('library/Autoload.php');

use CodeMommy\RoutePHP\Library\Autoload;

$autoloadDirectory = array(
    'library' => 'CodeMommy\\RoutePHP\\Library',
    'interface' => 'CodeMommy\\RoutePHP',
    'class' => 'CodeMommy\\RoutePHP'
);

Autoload::directory($autoloadDirectory);
