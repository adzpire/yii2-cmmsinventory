<?php

namespace backend\modules\inventory\controllers;

use Yii;
use backend\modules\inventory\models\InvtBudgettype;
use backend\modules\inventory\models\InvtBudgettypeSearch;
use backend\components\AdzpireComponent;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\web\Response;
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

/**
 * InvtbdgtController implements the CRUD actions for InvtBudgettype model.
 */
class InvtbdgtController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public $moduletitle;
    public function beforeAction(){
        $this->moduletitle = Yii::t('app', Yii::$app->controller->module->params['title']);
        return true;
    }

    /**
     * Lists all InvtBudgettype models.
     * @return mixed
     */
    public function actionIndex()
    {
		 
		 Yii::$app->view->title = 'รายการประเภทเงิน - '.$this->moduletitle;
		 
        $searchModel = new InvtBudgettypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InvtBudgettype model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        Yii::$app->view->title = 'รายละเอียด : '.$model->id.' - '.$this->moduletitle;
		 
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new InvtBudgettype model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		 Yii::$app->view->title = 'สร้างใหม่ - '.$this->moduletitle;
		 
        $model = new InvtBudgettype();

		/* if enable ajax validate
		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}*/
		
        if ($model->load(Yii::$app->request->post())) {
			if($model->save()){
                AdzpireComponent::succalert('addflsh', 'เพิ่มเรียบร้อย');
			    return $this->redirect(['view', 'id' => $model->id]);
			}else{
                AdzpireComponent::dangalert('addflsh', 'เพิ่มไม่ได้');
			}
            print_r($model->getErrors());
        }

            return $this->render('create', [
                'model' => $model,
            ]);
        

    }

    /**
     * Updates an existing InvtBudgettype model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

		 Yii::$app->view->title = Yii::t('inventory/app', 'Update {modelClass}: ', [
    'modelClass' => 'Invt Budgettype',
]) . $model->id.' - '.$this->moduletitle;

        if ($model->load(Yii::$app->request->post())) {
			if($model->save()){
                AdzpireComponent::succalert('edtflsh', 'ปรับปรุงเรียบร้อย');
			    return $this->redirect(['view', 'id' => $model->id]);
			}else{
                AdzpireComponent::dangalert('edtflsh', 'ปรับปรุงไม่ได้');
			}
            print_r($model->getErrors());
        } 

            return $this->render('update', [
                'model' => $model,
            ]);
        

    }

    /**
     * Deletes an existing InvtBudgettype model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        AdzpireComponent::succalert('edtflsh', 'ลบเรียบร้อย');

        return $this->redirect(['index']);
    }

    /**
     * Finds the InvtBudgettype model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InvtBudgettype the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InvtBudgettype::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
