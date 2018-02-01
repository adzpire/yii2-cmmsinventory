<?php

namespace backend\modules\inventory\controllers;

use Yii;
use backend\modules\inventory\models\InvtStathistory;
use backend\modules\inventory\models\InvtStathistorySearch;
use backend\modules\inventory\models\InvtStatus;
use backend\components\AdzpireComponent;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\web\Response;
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

/**
 * InvtstathisController implements the CRUD actions for InvtStathistory model.
 */
class InvtstathisController extends Controller
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
     * Lists all InvtStathistory models.
     * @return mixed
     */
    public function actionIndex()
    {
		 
		 Yii::$app->view->title = 'รายการประวัตืสถานะ - '.$this->moduletitle;
		 
        $searchModel = new InvtStathistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $filterS = InvtStatus::getStatusList();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'filterS' => $filterS,
        ]);
    }

    /**
     * Displays a single InvtStathistory model.
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
     * Creates a new InvtStathistory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		 Yii::$app->view->title = 'สร้างใหม่ - '.$this->moduletitle;
		 
        $model = new InvtStathistory();

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

        $statlist = InvtStatus::getStatusList();
        //print_r($statlist);exit();
            return $this->render('create', [
                'model' => $model,
                'statlist' => $statlist,
            ]);
        

    }

    /**
     * Updates an existing InvtStathistory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		 $model = $this->findModel($id);
		 
		 Yii::$app->view->title = Yii::t('inventory/app', 'Update {modelClass}: ', [
    'modelClass' => 'Invt Stathistory',
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

        $statlist = InvtStatus::getStatusList();

            return $this->render('update', [
                'model' => $model,
                'statlist' => $statlist,
            ]);
        

    }

    /**
     * Deletes an existing InvtStathistory model.
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

    /*************
     * select2 ajax
     ************/
    public function actionInvtlist($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new \yii\db\Query;
            $query->select(['id', new \yii\db\Expression("CONCAT(`invt_name`, ' brand: ', `invt_brand`, ' code: ', `invt_code`) as text")])
                ->from('invt_main')
                ->where(['like', 'invt_name', $q])
                ->orWhere(['like', 'invt_code', $q])
                ->orWhere(['like', 'invt_detail', $q])
                ->orWhere(['like', 'invt_occupyby', $q])
                ->orWhere(['like', 'invt_brand', $q]);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => InvtMain::find($id)->invt_name];
        }
        return $out;
    }

    /**
     * Finds the InvtStathistory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InvtStathistory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InvtStathistory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
