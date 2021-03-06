<?php

namespace backend\modules\inventory\controllers;

use Yii;
use backend\modules\inventory\models\FormInvttakeItems;
use backend\modules\inventory\models\FormInvttakeItemsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\components\AdzpireComponent;

use yii\web\Response;
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * InvttakeitemsController implements the CRUD actions for FormInvttakeItems model.
 */
class InvttakeitemsController extends Controller
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
			/* 'access' => [
                'class' => AccessControl::className(),
                'only' => ['enrol', 'deleteenrol'],
                'rules' => [
                    [
                        'actions' => ['enrol'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $model = $this->findDataModel(Yii::$app->request->get('id'));
                            if (!empty($model->attendee) OR !$model->remainseat[0]) {
                                return false;
                            } else {
                                return true;
                            }
                        }
                    ],
                    [
                        'actions' => ['deleteenrol'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $model = $this->findModel(Yii::$app->request->get('id'));
                            if ($model->username != $_SESSION['ldapData']['accountname']) {
                                return false;
                            } else {
                                return true;
                            }
                        }
                    ],
                ],
            ], */
        ];
    }

	public $moduletitle;
    public function beforeAction($action){
			$this->moduletitle = Yii::t('app', Yii::$app->controller->module->params['title']);

        return parent::beforeAction($action);
		  /* 
        if(ArrayHelper::isIn(Yii::$app->user->id, Yii::$app->controller->module->params['adminModule'])){
            //echo 'you are passed';
        }else{
            throw new ForbiddenHttpException('You have no right. Must be admin module.');
        }
        */
    }
	 
    /**
     * Lists all FormInvttakeItems models.
     * @return mixed
     */
    public function actionIndex()
    {
		 
		 Yii::$app->view->title = 'รายการ - '. $this->moduletitle;
		 
        $searchModel = new FormInvttakeItemsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FormInvttakeItems model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		 $model = $this->findModel($id);
		 
		 Yii::$app->view->title = Yii::t('app', 'ดูรายละเอียด') . ' : ' .$model->ID.' - '. $this->moduletitle;
		 
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new FormInvttakeItems model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		 Yii::$app->view->title = Yii::t('app', 'สร้างใหม่') .' - '. $this->moduletitle;
		 
        $model = new FormInvttakeItems();

		/* if enable ajax validate
		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}*/
		
        if ($model->load(Yii::$app->request->post())) {
			if($model->save()){
				AdzpireComponent::succalert('addflsh', 'เพิ่มรายการใหม่เรียบร้อย');
				return $this->redirect(['view', 'id' => $model->ID]);	
			}else{
				AdzpireComponent::dangalert('addflsh', 'เพิ่มรายการไม่ได้');
			}
            print_r($model->getErrors());exit();
        }

            return $this->render('create', [
                'model' => $model,
            ]);
        

    }

    /**
     * Updates an existing FormInvttakeItems model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		 $model = $this->findModel($id);
		 
		 Yii::$app->view->title = 'ปรับปรุงรายการ Form Invttake Items: ' . $model->ID.' - '. $this->moduletitle;
		 
        if ($model->load(Yii::$app->request->post())) {
			if($model->save()){
				AdzpireComponent::succalert('edtflsh', 'ปรับปรุงรายการเรียบร้อย');
			return $this->redirect(['view', 'id' => $model->ID]);	
			}else{
				AdzpireComponent::dangalert('edtflsh', 'ปรับปรุงรายการไม่ได้');
			}
            print_r($model->getErrors());exit();
        } 

            return $this->render('update', [
                'model' => $model,
            ]);
        

    }

    /**
     * Deletes an existing FormInvttakeItems model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
		
		AdzpireComponent::succalert('edtflsh', 'ลบรายการเรียบร้อย');		

        return $this->redirect(['index']);
    }

    /**
     * Finds the FormInvttakeItems model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FormInvttakeItems the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FormInvttakeItems::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('ไม่พบหน้าที่ต้องการ.');
        }
    }
}
