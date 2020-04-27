<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\Servers;
use Yii;

class ServerController extends Controller
{

    public function actionAdd()
    {
        /*
         * Добавить сервер
         * Пример:
         * http://localhost:8080/server/add?key=123
         */

        $model = new Servers;

        $request = Yii::$app->request;
        $key = $request->get('key');

        $model->key = $key;

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;

        if ($model->save()) {
            $response->data = ['message' => 'isOnline'];
        } else {
            $response->data = ['message' => 'Error'];
        }

        return $response;
    }

    public function actionDel()
    {
        /*
         * Удаление сервера
         * Пример:
         * http://localhost:8080/server/del?key=123
         */

        $request = Yii::$app->request;
        $key = $request->get('key');

        $model = Servers::find()->where(['key' => $key])->one();

        if ($model != null) {
            $model->delete();
        }

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;

        $response->data = ['message' => 'isOffline'];

        return $response;
    }
}
