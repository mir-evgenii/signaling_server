<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\commands\DeamonClass;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        var_dump([
            'extension_loaded' => extension_loaded('pcntl'),
            'pcntl_signal exists' => function_exists('pcntl_signal'),
            'pcntl_fork exists' => function_exists('pcntl_fork'),
        ]);

        // Создаем дочерний процесс
        // весь код после pcntl_fork() будет выполняться двумя процессами: родительским и дочерним
        $child_pid = pcntl_fork();
        if ($child_pid) {
            // Выходим из родительского, привязанного к консоли, процесса
            exit();
        }
        // Делаем основным процессом дочерний.
        posix_setsid();

        // Дальнейший код выполнится только дочерним процессом, который уже отвязан от консоли

        $baseDir = dirname(__FILE__);
        ini_set('error_log',$baseDir.'/error.log');
        fclose(STDIN);
        fclose(STDOUT);
        fclose(STDERR);
        $STDIN = fopen('/dev/null', 'r');
        $STDOUT = fopen($baseDir.'/application.log', 'ab');
        $STDERR = fopen($baseDir.'/daemon.log', 'ab');

        include 'DaemonClass.php';
        $daemon = new DaemonClass();
        $daemon->run();

        // ????
        return ExitCode::OK;
    }
}
