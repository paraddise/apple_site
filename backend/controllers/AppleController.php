<?php

namespace backend\controllers;

use common\models\Apple;
use common\models\AppleQuery;
use common\models\CreateAppleForm;
use yii\base\ErrorException;
use yii\data\ActiveDataProvider;
use yii\debug\models\timeline\DataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AppleController extends Controller
{

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ]); // TODO: Change the autogenerated stub
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Apple::find(),
        ]);
        array_map(fn ($model) => $this->checkRottenApple($model), $dataProvider->getModels(), );
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate()
    {
        $createCount = rand(\Yii::$app->params['apple.create.min'], \Yii::$app->params['apple.create.max']);
        for ($i = 0; $i < $createCount; $i++) {
            if (!($model = new CreateAppleForm())->save()) {
                return print_r($model->errors, true);
            }
        }
        return $this->redirect(['/apple/index']);
    }

    public function actionFall($id)
    {
        $model = $this->findModel($id);
        if (!$model->isFallen()) {
            if ($model->fall()) {
                \Yii::$app->session->setFlash('success', 'You picked the apple');
            } else {
                \Yii::$app->session->setFlash('danger', 'Sorry, some error occurred');
            }
        } else {
            \Yii::$app->session->setFlash('info', 'Apple has already fallen');
        }
        $this->redirect(['apple/index']);

    }

    public function actionEat($id, $payload)
    {
        $model = $this->findModel($id);
        if ($model->canEat()) {
            $model->eat($payload);
            if ($model->eaten >= 100) {
                \Yii::$app->session->setFlash('success', 'Wow, you\'ve eaten the apple');
            }
        }
        if ($model->isRotten()) {
            \Yii::$app->session->setFlash('danger', 'You cannot eat this apple, it\'s rotten');
        }
        if (!$model->isFallen()) {
            \Yii::$app->session->setFlash('info', 'Apple should fall before you can eat it');
        }
        $this->redirect(['apple/index']);

    }

    protected function findModel($id)
    {
        $model = Apple::findOne($id);
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Such apple not found', 404);
    }

    /**
     * Checks if the apple is rotten
     * returns whether the apple is rotten or not
     *
     * @param $model Apple
     * @return bool
     */
    protected function checkRottenApple($model)
    {
        if ($model->isFallen()) {
            if ((time() - $model->fell_at) > \Yii::$app->params['apple.shelfLife']) {
                $model->rot();
                return true;
            }
            return false;
        }
        return false;
    }

}