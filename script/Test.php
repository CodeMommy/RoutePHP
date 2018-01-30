<?php

/**
 * CodeMommy RoutePHP
 * @author Candison November <www.kandisheng.com>
 */

namespace CodeMommy\RoutePHP\Script;

use CodeMommy\TaskPHP\Console;
use CodeMommy\TaskPHP\FileSystem;

/**
 * Class Test
 * @package CodeMommy\RoutePHP\Script
 */
class Test
{
    /**
     * Test constructor.
     */
    public function __construct()
    {
    }

    /**
     * Start
     */
    public static function start()
    {
        $removeList = array(
            '.report'
        );
        $result = FileSystem::remove($removeList);
        if ($result) {
            Console::printLine('Clean Report Finished.', 'success');
        } else {
            Console::printLine('Clean Report Error.', 'error');
        }
        system('"vendor/bin/phpunit" -v');
        $reportFile = '.report/index.html';
        if (is_file($reportFile)) {
            system(sprintf('start %s', $reportFile));
        } else {
            Console::printLine('No Report.', 'information');
        }
    }
}
