<?php

use app\models\Status;
use yii\bootstrap5\Html;
use yii\helpers\VarDumper;

// VarDumper::dump($model->attributes, 10, true);
?>

<div class="card mb-4">
  <div class="card-header fw-semibold fs-5">
    № <?= $model->id ?> от <?= Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i:s') ?>
  </div>
  <div class="card-body">
    <h5 class="card-title text-decoration-underline">Дата и время услуги: <?= Yii::$app->formatter->asDate($model->date, 'php:d.m.Y') . ' ' . $model->time ?></h5>
    <p class="card-text">Клиент: <span class="fs-5"><?= $model->user->full_name ?></span></p>


    <p class="card-text">Наименование услуги: <span class="fs-5"><?= $model->service?->title ?></span></p>
    <p class="card-text fs-5"><span class="text-black-50">Наименование услуги: </span><?= $model->service?->title ?></p>


    <p class="card-text fs-5"><span class="text-black-50">Статус: </span><?= $model->status->title ?></p>
    <div class='d-flex '>
      <?= Html::a('Просмотр', ['view', 'id' => $model->id], ['class' => "btn btn-outline-primary"]) ?>

    </div>
    <div>
      <div>
        Первый вариант работы с заявкой
      </div>
      <?= $model->status_id == Status::getStatusId('Новая')
        ? Html::a('В работу', ['work', 'id' => $model->id], ['class' => "btn btn-outline-primary mx-3"])
        . Html::a('Отмена', ['cancel', 'id' => $model->id], ['class' => "btn btn-outline-warning"])
        : ''
      ?>
      <?= $model->status_id == Status::getStatusId('В работе')
        ? Html::a('Выполнено', ['apply', 'id' => $model->id], ['class' => "btn btn-outline-success mx-3"])
        : ''
      ?>
    </div>
    <div>
      <div>
        Второй вариант работы с заявкой
      </div>
      <?= $model->status_id == Status::getStatusId('Новая')
        ? Html::a('В работу', ['work', 'id' => $model->id], ['class' => "btn btn-outline-primary mx-3"])
        : ''
      ?>
      <?= $model->status_id == Status::getStatusId('В работе')
        ? Html::a('Выполнено', ['apply', 'id' => $model->id], ['class' => "btn btn-outline-success mx-3"])
        . Html::a('Отмена', ['cancel', 'id' => $model->id], ['class' => "btn btn-outline-warning"])
        : ''
      ?>
    </div>



  </div>
</div>
