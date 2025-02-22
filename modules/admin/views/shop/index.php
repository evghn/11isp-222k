<?php
/** @var yii\web\View $this */

use yii\bootstrap5\Html;

?>
<h3>Панель управления интернет-магазином</h3>

<p>
    <?= Html::a('Категории', ['/admin/category'], ['class' => 'btn btn-info'])?>
    <?= Html::a('Товары', ['/admin/product'], ['class' => 'btn btn-success'])?>
    
</p>
