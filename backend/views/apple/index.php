<?php

/** @var $this \yii\web\View */
/** @var $dataProvider \yii\data\ActiveDataProvider */
$this->title = 'Apples';
$this->params['breadcrumbs'][] = 'Apples';
?>
<?=  \yii\bootstrap4\Html::a('Вырастить ещё яблок', ['/apple/create']) ?>
<?= \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_apple',
    'sorter' => [
        'options' => ['class' => 'd-flex list-unstyled p-auto'],
        'linkOptions' => ['class' => 'btn btn-primary mr-3'],
        'attributes' => [
            'created_at',
            'eaten',
            'fell_at'
        ],
    ],
    'pager' => [
        'linkOptions' => ['class' => 'page-link'],
        'activePageCssClass' => 'active',
        'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link'],
        'linkContainerOptions' => ['class' => 'page-item'],
        'nextPageLabel' => 'Next',
        'prevPageLabel' => 'Prev',
        'disableCurrentPageButton' => true

    ],
    'layout' => '{sorter}{summary}<div id="apple-items">{items}</div>{pager}'
]) ?>



