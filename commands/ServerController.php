<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

class ServerController extends Controller
{
    const MY_SERVER_KEY = 'qwe123';

    public function actionAddMyServer()
    {
        $key = self::MY_SERVER_KEY;

        $host = 'localhost';
        $port = 8080;

        $message = file_get_contents("http://{$host}:{$port}/web/index.php?r=server/add-server&key={$key}");

        echo $message . "\n";

        return ExitCode::OK;
    }

    public function actionSendServerMessage()
    {
        $message = file_get_contents('http://localhost:8080/web/index.php?r=message/send-message&content=text&sender=123&recipient=345');

        echo $message . "\n";

        return ExitCode::OK;
    }

    public function actionSendServerClient()
    {
        $message = file_get_contents('http://localhost:8080/web/index.php?r=client/add-client&key=345');

        echo $message . "\n";

        return ExitCode::OK;
    }
}
