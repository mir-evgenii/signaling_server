<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

// выводим сообщение об успехе или ошибку
include 'msg.php';

echo "<h4 class='text-black-50 mb-3'>Создание товара</h4>";

// Форма создания товара
$input = ActiveForm::begin();

// выводим поля
echo $input->field($form_good, 'good')
	->label('Имя нового товара', ['class' => 'font-weight-bold text-black-50']);
echo $input->field($form_good, 'price')
	->label('Цена товара', ['class' => 'font-weight-bold text-black-50']);
echo $input->field($form_good, 'number')
	->label('Количество', ['class' => 'font-weight-bold text-black-50']);
echo $input->field($form_link, 'id_category')
	->dropDownList($arr_all_categorys)
	->label('Категория', ['class' => 'font-weight-bold text-black-50']);

// выводим кнопки
echo "<div class='btn-group mt-3'>";
echo Html::submitButton('Создать товар',
	['class' => 'btn btn-outline-success']);
echo "<a class='btn btn-outline-primary' 
	href='index.php' role='button'>Назад</a>";
echo "</div>";

ActiveForm::end();
