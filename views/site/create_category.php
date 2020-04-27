<?php
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use yii\helpers\Html;

// выводим сообщение об ошибке или успехе
include 'msg.php';

echo "<h4 class='text-black-50 mb-3'>Создание категории</h4>";

// Форма создания категории
$input = ActiveForm::begin();

// выводим поля
echo $input->field($form_category, 'category')
	->label('Имя новой категории', ['class' => 'font-weight-bold text-black-50']);
echo $input->field($form_clink, 'id_category_parent')
	->dropDownList($arr_all_categorys)
	->label('Категория', ['class' => 'font-weight-bold text-black-50']);

// выводим кнопки
echo "<div class='btn-group mt-3'>";
echo Html::submitButton('Создать категорию',
	['class' => 'btn btn-outline-success']);
echo "<a class='btn btn-outline-primary' 
	href='index.php' role='button'>Назад</a>";
echo "</div>";

ActiveForm::end();
