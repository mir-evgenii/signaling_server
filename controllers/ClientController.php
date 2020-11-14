<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\Clients;
use Yii;

class ClientController extends Controller
{
    public function actionAdd()
    {
        /*
         * Добавление пользователя
         * Пример:
         * http://localhost:8080/client/add?key=123
         */

        $model = new Clients;

        $request = Yii::$app->request;
        $key = $request->get('key');

        $model->key = $key;

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->headers->set('Access-Control-Allow-Origin', '*');

        if ($model->save()) {
            $response->data = ['message' => 'isOnline'];
        } else {
            $response->data = ['message' => 'Error'];
        }

        return $response;
    }

    public function actionGet()
    {
        /*
         * Получить список пользователей онлайн
         * Пример:
         * http://localhost:8080/client/get?keys=123;345;456
         */

        $request = Yii::$app->request;
        $keys = $request->get('keys');

        $arrKeys = explode (';', $keys);
        $arrOnlineKey = [];

        foreach ($arrKeys as $key) {
        $model = Clients::find()->where(['key' => $key])->one();
            if ($model != null) {
                $arrOnlineKey[] = $key;
            }
        }

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->data = ['online_users' => $arrOnlineKey];

        return $response;
    }

    public function actionDel()
    {
        /*
         * Удалить пользователя
         * Пример:
         * http://localhost:8080/client/del?key=123
         */

        $request = Yii::$app->request;
        $key = $request->get('key');

        $model = Clients::find()->where(['key' => $key])->one();

        if ($model != null) {
            $model->delete();
        }

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->data = ['message' => 'isOffline'];

        return $response;
    }
}
