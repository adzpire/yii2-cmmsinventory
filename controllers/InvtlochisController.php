<?php

namespace backend\modules\inventory\controllers;

use Yii;
use backend\modules\inventory\models\InvtLochistory;
use backend\modules\inventory\models\InvtLochistorySearch;
use backend\modules\location\models\MainLocation;
use backend\modules\inventory\models\InvtMain;
use backend\modules\person\models\Person;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\web\Response;
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * InvtlochisController implements the CRUD actions for InvtLochistory model.
 */
class InvtlochisController extends Controller
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

    public $admincontroller = [20];

    public function beforeAction(){
        foreach($this->admincontroller as $key){
            array_push(Yii::$app->controller->module->params['adminModule'],$key);
        }

        return true;
        /*
        if(ArrayHelper::isIn(Yii::$app->user->id, Yii::$app->controller->module->params['adminModule'])){
            echo 'you are passed';
        }else{
            throw new ForbiddenHttpException('You have no right. Must be admin module.');
        }
        */
    }
    /**
     * Lists all InvtLochistory models.
     * @return mixed
     */
    public function actionIndex()
    {
		 
		 Yii::$app->view->title = Yii::t('inventory/app', 'Invt Lochistories').' - '.Yii::t('itinfo/app', Yii::$app->controller->module->params['title']);
		 
        $searchModel = new InvtLochistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InvtLochistory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		 $model = $this->findModel($id);
		 
		 Yii::$app->view->title = Yii::t('inventory/app', 'Detail').' : '.$model->id.' - '.Yii::t('itinfo/app', Yii::$app->controller->module->params['title']);
		 
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new InvtLochistory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($renderType = null)
    {
		 Yii::$app->view->title = Yii::t('inventory/app', 'Create').' - '.Yii::t('itinfo/app', Yii::$app->controller->module->params['title']);
		 
        $model = new InvtLochistory();

		/* if enable ajax validate
		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}*/

        /*$qinvt = InvtMain::find()->all();
        $invtarray = ArrayHelper::map($qinvt, 'id', 'invt_name');*/
        if ($model->load(Yii::$app->request->post())) {

            $model->update_by = Yii::$app->user->id;

			if($model->save()){
				Yii::$app->getSession()->setFlash('addflsh', [
				'type' => 'success',
				'duration' => 4000,
				'icon' => 'glyphicon glyphicon-ok-circle',
				'message' => Yii::t('inventory/app', 'UrDataCreated'),
				]);
			return $this->redirect(['view', 'id' => $model->id]);	
			}else{
				Yii::$app->getSession()->setFlash('addflsh', [
				'type' => 'danger',
				'duration' => 4000,
				'icon' => 'glyphicon glyphicon-remove-circle',
				'message' => Yii::t('inventory/app', 'UrDataNotCreated'),
				]);
			}
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $qloc = MainLocation::find()->all();
        $locarray = ArrayHelper::map($qloc, 'id', 'loc_name');

        $userlist = Person::getPersonList(true,true,false,false);

        if($renderType === 1){
            return $this->render('create', [
                'model' => $model,
                'locarray' => $locarray,
                'userlist' => $userlist,
            ]);
        }

        return $this->render('create', [
            'model' => $model,
            'locarray' => $locarray,
            'userlist' => $userlist,
        ]);
        

    }

    /**
     * Updates an existing InvtLochistory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		 $model = $this->findModel($id);
		 
		 Yii::$app->view->title = Yii::t('inventory/app', 'Update {modelClass}: ', [
    'modelClass' => 'Invt Lochistory',
]) . $model->id.' - '.Yii::t('itinfo/app', Yii::$app->controller->module->params['title']);
		 
        if ($model->load(Yii::$app->request->post())) {

            $model->update_by = Yii::$app->user->id;

			if($model->save()){
				Yii::$app->getSession()->setFlash('edtflsh', [
				'type' => 'success',
				'duration' => 4000,
				'icon' => 'glyphicon glyphicon-ok-circle',
				'message' => Yii::t('inventory/app', 'UrDataUpdated'),
				]);
			return $this->redirect(['view', 'id' => $model->id]);	
			}else{
				Yii::$app->getSession()->setFlash('edtflsh', [
				'type' => 'danger',
				'duration' => 4000,
				'icon' => 'glyphicon glyphicon-remove-circle',
				'message' => Yii::t('inventory/app', 'UrDataNotUpdated'),
				]);
			}
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $qloc = MainLocation::find()->all();
        $locarray = ArrayHelper::map($qloc, 'id', 'loc_name');

        $userlist = Person::getPersonList(true,true,false,false);

            return $this->render('update', [
                'model' => $model,
                'locarray' => $locarray,
                'userlist' => $userlist,
            ]);
    }

    /**
     * Deletes an existing InvtLochistory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
		
		Yii::$app->getSession()->setFlash('edtflsh', [
			'type' => 'success',
			'duration' => 4000,
			'icon' => 'glyphicon glyphicon-ok-circle',
			'message' => Yii::t('inventory/app', 'UrDataDeleted'),
		]);
		

        return $this->redirect(['index']);
    }

    /**
     * Finds the InvtLochistory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InvtLochistory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    /*************
     * select2 ajax
     ************/
    public function actionInvtlist($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new \yii\db\Query;
            $query->select('id, invt_name AS text')
                ->from('invt_main')
                ->where(['like', 'invt_name', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => InvtMain::find($id)->invt_name];
        }
        return $out;
    }

    protected function findModel($id)
    {
        if (($model = InvtLochistory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
