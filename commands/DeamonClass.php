<?php

namespace app\commands;

//declare(ticks=1);
pcntl_signal_dispatch();

class DaemonClass
{

    // Максимальное количество дочерних процессов
    public $maxProcesses = 5;
    // Когда установится в TRUE, демон завершит работу
    protected $stop_server = FALSE;
    // Здесь будем хранить запущенные дочерние процессы
    protected $currentJobs = array();

    public function __construct() {
        echo "Сonstructed daemon controller".PHP_EOL;
        // Ждем сигналы SIGTERM и SIGCHLD
        pcntl_signal(SIGTERM, array($this, "childSignalHandler"));
        pcntl_signal(SIGCHLD, array($this, "childSignalHandler"));
    }

    public function run() {
        echo "Running daemon controller".PHP_EOL;

        // Пока $stop_server не установится в TRUE, гоняем бесконечный цикл
        while (!$this->stop_server) {
            echo 'deamon work!';
            // Если уже запущено максимальное количество дочерних процессов, ждем их завершения
            while(count($this->currentJobs) >= $this->maxProcesses) {
                 echo "Maximum children allowed, waiting...".PHP_EOL;
                 sleep(1);
            }

            $this->launchJob();
        }
    }
}
