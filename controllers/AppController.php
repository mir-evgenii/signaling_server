<?php
namespace app\controllers;

use yii\web\Controller;
use Yii;

class AppController extends Controller
{
    public function actionGet()
    {
        /*
         * Получение экземпляра клиентского приложения
         * Пример:
         * http://localhost:8080/app/get
         */

        return $this->render('index');
    }
}
