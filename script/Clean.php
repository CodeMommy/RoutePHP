<?php

/**
 * CodeMommy RoutePHP
 * @author Candison November <www.kandisheng.com>
 */

namespace CodeMommy\RoutePHP\Script;

use CodeMommy\TaskPHP\Console;
use CodeMommy\TaskPHP\FileSystem;

/**
 * Class Clean
 * @package CodeMommy\RoutePHP\Script
 */
class Clean
{
    /**
     * Clean constructor.
     */
    public function __construct()
    {
    }

    /**
     * Start
     */
    public static function start()
    {
        PHPUnit::clean();
        $removeList = array(
            'workbench'
        );
        $result = FileSystem::remove($removeList);
        if ($result) {
            Console::printLine('Clean Finished.', 'success');
        } else {
            Console::printLine('Error.', 'error');
        }
    }
}
