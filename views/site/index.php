<?php
// Главная страница

// выводим сообщение об успехе или ошибку
include 'msg.php';

$this->params['id_this_category'] = $id;
$this->params['name_this_category'] = $name_this_category;

// выводим категории
if (@$categorys) {
    $this->beginContent('@app/views/layouts/category_table_head.php');
    $this->endContent();
    foreach ($categorys as $category) {
        $this->params['id'] = $category->child['0']->id;
        $this->params['category'] = $category->child['0']->category;
        $this->beginContent('@app/views/layouts/category_table_body.php');
        $this->endContent();
    }
    echo "</table>";
}

// выводим товары
if (@$goods) {
    $this->beginContent('@app/views/layouts/goods_table_head.php');
    $this->endContent();
    foreach ($goods as $good) {
        $this->params['id'] = $good->goods['0']->id;
        $this->params['good'] = $good->goods['0']->good;
        $this->params['price'] = $good->goods['0']->price;
        $this->params['number'] = $good->goods['0']->number;
        $this->beginContent('@app/views/layouts/goods_table_body.php');
        $this->endContent();
    }
    echo "</table>";
}

// выводим кнопку назад
if (@$id_parent_category) {
    echo "
<a class='btn btn-outline-primary' 
   href='index.php?r=site/index&id={$id_parent_category["id_category_parent"]}'
   role='button'>
    Назад
</a>
    ";
}
