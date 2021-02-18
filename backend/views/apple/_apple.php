<?php

use yii\bootstrap4\Html;
use \yii\helpers\Url;

/** @var $model \common\models\Apple */
$color = $model->color;
$timeFormat = 'dd/MM/yyyy h:i';
?>
<div class="apple-item text-center border d-flex flex-column justify-content-center align-items-center m-2" style="width: 250px;height: 250px;">
    <img src="/img/apple.png" class="rounded-circle" alt="Apple photo"
         style="background-color: <?= $color ?>;width: 100px;">
    <div>Состояние: <?= $model->getStateLabel() ?></div>

    <?php if ($model->isFallen() || $model->isRotten()): ?>
        <div>Съедено: <?= $model->eaten ?>%</div>
        <?php if ($model->isFallen()): ?>
            <form action="<?= Url::to('/apple/eat') ?>">
                <input type="number" value="<?= $model->id ?>" name="id" readonly hidden/>
                <input class="w-25" type="number" name="payload" max="<?= 100 - $model->eaten ?>"
                       value="<?= 100 - $model->eaten ?>" min="1"/>
                <button class="btn btn-info">Съесть</button>
            </form>
        <?php endif; ?>
        <?php if ($model->isRotten()): ?>
            <span class="text-danger">Яблоко сгнило</span>
        <?php endif; ?>

        <small>Упало: <?= \Yii::$app->formatter->asDatetime($model->fell_at, $timeFormat) ?> </small>
    <?php endif; ?>


    <?php if ($model->isCreated()): ?>
        <?= Html::a('Сорвать яблоко', ['/apple/fall', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
    <?php endif; ?>

    <small>Выросло: <?= \Yii::$app->formatter->asDatetime($model->created_at, $timeFormat) ?></small>
</div>
