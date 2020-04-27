<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

// выводим сообщение об успехе или ошибку
include 'msg.php';

echo "<h4 class='text-black-50 mb-3'>Изменение категории</h4>";

// Форма изменения категории
$input = ActiveForm::begin();

// выводим поля
echo $input->field($form_category, 'category')
	->label('Имя категории', ['class' => 'font-weight-bold text-black-50']);

// проверяем переданы ли данные о родительской категории
if ($form_clink) {
    echo $input->field($form_clink, 'id_category_parent')
    	->dropDownList($arr_all_categorys)
    	->label('Категория', ['class' => 'font-weight-bold text-black-50']);
} else {
    echo "<div class='alert alert-primary' role='alert'>
    	Это корневая категория, она не вложена не в одну категорию.</div>";
}

// выводим кнопки
echo "<div class='btn-group mt-3'>";
echo Html::submitButton('Изменить категорию',
	['class' => 'btn btn-outline-success']);
echo "<a class='btn btn-outline-primary'
	href='index.php?r=site/index&id={$id_parent_category["id_category_parent"]}'
	role='button'>Назад</a>";
echo "</div>";

ActiveForm::end();
