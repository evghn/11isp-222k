<?php

namespace app\modules\admin\controllers;

use app\models\Application;
use app\models\Status;
use app\modules\admin\models\ApplicationSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ApplicationController implements the CRUD actions for Application model.
 */
class ApplicationController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Application models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Application model.
     * @param int $id № заявки
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Application model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Application();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Application model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id № заявки
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    public function actionWork($id)
    {
        if ($model = $this->findModel($id)) {
            $model->status_id = Status::getStatusId('В работе');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Заявка передана в работу');
            }
        }

        return $this->redirect('index');
    }


    public function actionApply($id)
    {
        if ($model = $this->findModel($id)) {
            $model->status_id = Status::getStatusId('Выполнено');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 
                    'Заявка №' 
                        . $model->id 
                        . 'от ' . Yii::$app->formatter->asDate($model->created_at, 'php:d.m.Y')
                        . ' выполнена!');
            }
        }

        return $this->redirect('index');
    }


    


    public function actionCancel($id)
    {
        if ($model = $this->findModel($id)) {
            $model->scenario = Application::SCENARIO_CANCEL;
            
            if ($this->request->isPost && $model->load($this->request->post())) {

                $model->status_id = Status::getStatusId('Отменено');
                if ($model->save()) {
                    Yii::$app->session->setFlash('warning', 'Заявка отменена');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
    
            return $this->render('cancel', [
                'model' => $model,
            ]);
        }

        return $this->redirect('index');
    }
    


    

    /**
     * Deletes an existing Application model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id № заявки
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Application model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id № заявки
     * @return Application the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Application::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
