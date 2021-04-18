<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\Messages;
use app\traits\traitSign;
use Yii;

class MessageController extends Controller
{
    use traitSign;

    public function actionSend()
    {
        /*
         * Отправка сообщения
         * Пример:
         * http://localhost:8080/message/send?content=text&sender=123&recipient=345&date=2020-04-27 10:00:00&sign=1234314
         */

        $model = new Messages;

        $request = Yii::$app->request;

        Yii::info($request, __METHOD__);

        $model->content = $request->get('content');
        $model->recipient = $request->get('recipient');
        $model->sender = $request->get('sender');
        $model->datetime = $request->get('date');
        $model->sign = $request->get('sign');

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->headers->set('Access-Control-Allow-Origin', '*');

        //$message = $model->datetime.' '.$model->content;
        $message = $model->content;


        if ($model->save()) {
            $response->data = ['message' => 'send'];
        } else {
            $response->data = ['message' => 'Error, not save message.'];
        }

        Yii::info($response, __METHOD__);

        return $response;
    }

    public function actionGet()
    {
        /*
         * Получить все новые сообщения
         * Пример:
         * http://localhost:8080/message/get?key=345
         */

        $request = Yii::$app->request;
        $key = $request->get('key');

        Yii::info($request, 'Get-Msg Req');

        $model = Messages::find()->where(['recipient' => $key])->all();

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->data = ['messages-for-client' => $model];

        $this->delMessagesForClient($key);

        Yii::info($response, 'Get-Msg Res');

        return $response;
    }

    private function delMessagesForClient($recipient)
    {
        /*
         * Удаление сообщений
         * сообщения удаляются после того как получатель их получит
         */

        $model = Messages::deleteAll(['recipient' => $recipient]);
    }
}
