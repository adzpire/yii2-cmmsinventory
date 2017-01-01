<?php

namespace backend\modules\inventory\controllers;

use Yii;
use backend\modules\inventory\models\InvtMain;
use backend\modules\inventory\models\InvtMainSearch;
use backend\modules\inventory\models\InvtType;
use backend\modules\inventory\models\InvtBudgettype;
use backend\modules\inventory\models\InvtStatus;
use backend\modules\inventory\models\InvtLochistory;
use backend\modules\inventory\models\InvtStathistory;

use backend\modules\location\models\MainLocation;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

use yii\filters\VerbFilter;

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * InvtmainController implements the CRUD actions for InvtMain model.
 */
class InvtmainController extends Controller
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

    /**
     * Lists all InvtMain models.
     * @return mixed
     */
    public function actionIndex()
    {
		 
		 Yii::$app->view->title = Yii::t('inventory/app', 'ครุภัณฑ์หลัก').' - '.Yii::t('itinfo/app', Yii::$app->controller->module->params['title']);
		 
        $searchModel = new InvtMainSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InvtMain model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        Yii::$app->view->title = Yii::t('inventory/app', 'ดูรายละเอียด').' : '.$model->id.' - '.Yii::t('itinfo/app', Yii::$app->controller->module->params['title']);
		 
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new InvtMain model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id = NULL)
    {
		 Yii::$app->view->title = Yii::t('inventory/app', 'สร้างใหม่').' - '.Yii::t('itinfo/app', Yii::$app->controller->module->params['title']);
		 
        $model = new InvtMain();

        /* if enable ajax validate*/
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if (Yii::$app->request->isPost) {

            $model->file = UploadedFile::getInstance($model, 'file');
            if(isset($model->file)){
                if ($model->upload()) {
                    $model->invt_image = basename($model->filepath);
                    Yii::$app->getSession()->setFlash('addfile', [
                        'type' => 'success',
                        'duration' => 4000,
                        'icon' => 'glyphicon glyphicon-ok-circle',
                        'message' => Yii::t('inventory/app', 'อัพโหลดไฟล์เรียบร้อย'),
                    ]);

                }else{
                    Yii::$app->getSession()->setFlash('addfile', [
                        'type' => 'danger',
                        'duration' => 4000,
                        'icon' => 'glyphicon glyphicon-ok-circle',
                        'message' => Yii::t('inventory/app', 'อัพโหลดไฟล์ไม่ได้!'),
                    ]);
                }

            }

        }

        if ($model->load(Yii::$app->request->post())) {
			if($model->save()){

                $lh = new InvtLochistory();
                $lh->invt_ID = $model->id;
                $lh->invt_locID = $model->invt_locationID;
                $lh->date = date('Y-m-d');
                $lh->update_by = Yii::$app->user->id;

                if ($lh->save()) {
                    Yii::$app->getSession()->setFlash('addlochisflsh', [
                        'type' => 'success',
                        'duration' => 4000,
                        'icon' => 'glyphicon glyphicon-ok-circle',
                        'message' => Yii::t('inventory/app', 'เพิ่มประวัติสถานที่เรียบร้อย'),
                    ]);
                } else {
                    Yii::$app->getSession()->setFlash('addlochisflsh', [
                        'type' => 'danger',
                        'duration' => 4000,
                        'icon' => 'glyphicon glyphicon-ok-circle',
                        'message' => Yii::t('inventory/app', 'เพิ่มประวัติสถานที่ไม่ได้'),
                    ]);
                }

                $sh = new InvtStathistory();
                $sh->invt_ID = $model->id;
                $sh->invt_statID = $model->invt_statID;
                $sh->date = date('Y-m-d');

                if ($sh->save()) {
                    Yii::$app->getSession()->setFlash('addstashisflsh', [
                        'type' => 'success',
                        'duration' => 4000,
                        'icon' => 'glyphicon glyphicon-ok-circle',
                        'message' => Yii::t('inventory/app', 'เพิ่มประวัติสถานะเรียบร้อย'),
                    ]);
                } else {
                    Yii::$app->getSession()->setFlash('addatathisflsh', [
                        'type' => 'danger',
                        'duration' => 4000,
                        'icon' => 'glyphicon glyphicon-ok-circle',
                        'message' => Yii::t('inventory/app', 'เพิ่มประวัติสถานะไม่ได้'),
                    ]);
                }

				Yii::$app->getSession()->setFlash('addflsh', [
				'type' => 'success',
				'duration' => 4000,
				'icon' => 'glyphicon glyphicon-ok-circle',
				'message' => Yii::t('inventory/app', 'เพิ่มรายการใหม่เรียบร้อย'),
				]);
                if(isset(Yii::$app->request->post()['save&go']))
                {
                    return $this->redirect(['create', 'id' => $model->id]);
                }else{
                    return $this->redirect(['view', 'id' => $model->id]);
                }
			}else{
				Yii::$app->getSession()->setFlash('addflsh', [
				'type' => 'danger',
				'duration' => 4000,
				'icon' => 'glyphicon glyphicon-remove-circle',
				'message' => Yii::t('inventory/app', 'เพิ่มรายการไม่ได้'),
				]);
			}
            print_r($model->getErrors());exit;
        }

        $qinvtt = InvtType::find()->all();
        $invttarray = ArrayHelper::map($qinvtt, 'id', 'invt_tname');

        $qbgtt = InvtBudgettype::find()->all();
        $bdgttyparray = ArrayHelper::map($qbgtt, 'id', 'invt_bname');

        $qinvtstat = InvtStatus::find()->all();
        $invtstatarray = ArrayHelper::map($qinvtstat, 'id', 'invt_sname');

        $qloc = MainLocation::find()->all();
        $locarray = ArrayHelper::map($qloc, 'id', 'loc_name');

        $qbrand = InvtMain::find()->select('invt_brand')->distinct()->asArray()->all();
        $brndarr = [];
        foreach($qbrand as $key => $value){
            array_push($brndarr,$value['invt_brand']);
        }
        $qocpy = InvtMain::find()->select('invt_occupyby')->distinct()->asArray()->all();
        $ocpyarr = [];
        foreach($qocpy as $key => $value){
            array_push($ocpyarr,$value['invt_occupyby']);
        }
        $qbfrom = InvtMain::find()->select('invt_buyfrom')->distinct()->asArray()->all();
        $bfromarr = [];
        foreach($qbfrom as $key => $value){
            array_push($bfromarr,$value['invt_buyfrom']);
        }
        $qcode = InvtMain::find()->select('invt_code')->limit(10)->distinct()->asArray()->all();
        $codearr = [];
        foreach($qcode as $key => $value){
            array_push($codearr,$value['invt_code']);
        }
        if(isset($id) && $this->findModel($id)){
            $model2 = $this->findModel($id); // record that we want to duplicate
            $model = $model2;
            $model->isNewRecord = true;
        }

            return $this->render('create', [
                'id' => $id,
                'model' => $model,
                'invttarray' => $invttarray,
                'bdgttyparray' => $bdgttyparray,
                'invtstatarray' => $invtstatarray,
                'locarray' => $locarray,
                'brndarr' => $brndarr,
                'ocpyarr' => $ocpyarr,
                'bfromarr' => $bfromarr,
                'codearr' => $codearr,
            ]);
        

    }

    public function actionCreatetype()
    {

        $model = new InvtType();

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                echo 1;
            }else{
                echo 0;
            }

        }else{
            return $this->renderAjax('_formtype', [
                'model' => $model,
            ]);
        }


    }

    public function actionCreateloca()
    {

        $model = new MainLocation();

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                echo 1;
            }else{
                echo 0;
            }

        }else{
            return $this->renderAjax('_formloca', [
                'model' => $model,
            ]);
        }


    }

    public function actionGetlist($src = NULL)
    {
        if(isset($src) && $src == 'invtt'){
            $qinvtt = InvtType::find()->all();
            $invttarray = ArrayHelper::map($qinvtt, 'id', 'invt_tname');
            foreach($invttarray as $key => $value){
                echo "<option value='".$key."'>".$value."</option>";
            }
        }elseif(isset($src) && $src == 'bdgttyp'){
            $qbgtt = InvtType::find()->all();
            $invttarray = ArrayHelper::map($qbgtt, 'id', 'invt_tname');
            foreach($invttarray as $key => $value){
                echo "<option value='".$key."'>".$value."</option>";
            }
        }elseif(isset($src) && $src == 'invtloc'){
            $qbgtt = MainLocation::find()->all();
            $invttarray = ArrayHelper::map($qbgtt, 'id', 'loc_name');
            foreach($invttarray as $key => $value){
                echo "<option value='".$key."'>".$value."</option>";
            }
        }else{
            echo "<option value='0'>nothing</option>";
        }
    }
    /**
     * Updates an existing InvtMain model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        Yii::$app->view->title = Yii::t('inventory/app', 'ปรับปรุงรายการ {modelClass}: ', [
    'modelClass' => 'Invt Main',
]) . $model->id.' - '.Yii::t('itinfo/app', Yii::$app->controller->module->params['title']);


        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if (Yii::$app->request->isPost) {

            $model->file = UploadedFile::getInstance($model, 'file');
            if(isset($model->file)){
                if ($model->upload()) {
                    $model->invt_image = basename($model->filepath);
                    Yii::$app->getSession()->setFlash('addfile', [
                        'type' => 'success',
                        'duration' => 4000,
                        'icon' => 'glyphicon glyphicon-ok-circle',
                        'message' => Yii::t('inventory/app', 'อัพโหลดไฟล์เรียบร้อย'),
                    ]);

                }else{
                    Yii::$app->getSession()->setFlash('addfile', [
                        'type' => 'danger',
                        'duration' => 4000,
                        'icon' => 'glyphicon glyphicon-ok-circle',
                        'message' => Yii::t('inventory/app', 'อัพโหลดไฟล์ไม่ได้!'),
                    ]);
                }

            }

        }

        if ($model->load(Yii::$app->request->post())) {
			if($model->save()){
				Yii::$app->getSession()->setFlash('edtflsh', [
				'type' => 'success',
				'duration' => 4000,
				'icon' => 'glyphicon glyphicon-ok-circle',
				'message' => Yii::t('inventory/app', 'ปรับปรุงรายการเรียบร้อย'),
				]);
			return $this->redirect([isset(Yii::$app->request->post()['save&go']) ? 'create' : 'view', 'id' => $model->id]);
			}else{
				Yii::$app->getSession()->setFlash('edtflsh', [
				'type' => 'danger',
				'duration' => 4000,
				'icon' => 'glyphicon glyphicon-remove-circle',
				'message' => Yii::t('inventory/app', 'ปรับปรุงรายการไม่ได้'),
				]);
			}
            print_r($model->getErrors());exit;
        }

        $qinvtt = InvtType::find()->all();
        $invttarray = ArrayHelper::map($qinvtt, 'id', 'invt_tname');

        $qbgtt = InvtBudgettype::find()->all();
        $bdgttyparray = ArrayHelper::map($qbgtt, 'id', 'invt_bname');

        $qinvtstat = InvtStatus::find()->all();
        $invtstatarray = ArrayHelper::map($qinvtstat, 'id', 'invt_sname');

        $qloc = MainLocation::find()->all();
        $locarray = ArrayHelper::map($qloc, 'id', 'loc_name');

        $qbrand = InvtMain::find()->select('invt_brand')->distinct()->asArray()->all();
        $brndarr = [];
        foreach($qbrand as $key => $value){
            array_push($brndarr,$value['invt_brand']);
        }
        $qocpy = InvtMain::find()->select('invt_occupyby')->distinct()->asArray()->all();
        $ocpyarr = [];
        foreach($qocpy as $key => $value){
            array_push($ocpyarr,$value['invt_occupyby']);
        }
        $qbfrom = InvtMain::find()->select('invt_buyfrom')->distinct()->asArray()->all();
        $bfromarr = [];
        foreach($qbfrom as $key => $value){
            array_push($bfromarr,$value['invt_buyfrom']);
        }
        $qcode = InvtMain::find()->select('invt_code')->limit(10)->distinct()->asArray()->all();
        $codearr = [];
        foreach($qcode as $key => $value){
            array_push($codearr,$value['invt_code']);
        }

            return $this->render('update', [
                'model' => $model,
                'invttarray' => $invttarray,
                'bdgttyparray' => $bdgttyparray,
                'invtstatarray' => $invtstatarray,
                'locarray' => $locarray,
                'brndarr' => $brndarr,
                'ocpyarr' => $ocpyarr,
                'bfromarr' => $bfromarr,
                'codearr' => $codearr,
            ]);
        

    }

    public function actionChangeloc($id)
    {

        $model = $this->findModel($id);
        //$model->invt_ID = $model->id;
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                if(isset($model->oldloc) && $model->invt_locationID != $model->oldloc) {

                    $lh = new InvtLochistory();
                    $lh->invt_ID = $model->id;
                    $lh->invt_locID = $model->invt_locationID;
                    $lh->date = date('Y-m-d');
                    $lh->update_by = Yii::$app->user->id;

                    if ($lh->save()) {
                        Yii::$app->getSession()->setFlash('addlochisflsh', [
                            'type' => 'success',
                            'duration' => 4000,
                            'icon' => 'glyphicon glyphicon-ok-circle',
                            'message' => Yii::t('inventory/app', 'เพิ่มสถานที่ใหม่เรียบร้อย'),
                        ]);
                    } else {
                        Yii::$app->getSession()->setFlash('addlochisflsh', [
                            'type' => 'danger',
                            'duration' => 4000,
                            'icon' => 'glyphicon glyphicon-ok-circle',
                            'message' => Yii::t('inventory/app', 'เพิ่มสถานที่ไม่ได้'),
                        ]);
                    }
                }
                echo 1;
            }else{
                echo 0;
            }

        }else{
            $qloc = MainLocation::find()->all();
            $locarray = ArrayHelper::map($qloc, 'id', 'loc_name');

            return $this->renderAjax('changelocation', [
                'model' => $model,
                'locarray' => $locarray,
            ]);
        }
    }

    public function actionChangelocation($id)
    {
        $model = $this->findModel($id);

        Yii::$app->view->title = Yii::t('inventory/app', 'ปรับปรุงสถานที่ {modelClass}: ', [
                'modelClass' => 'Invt Main',
            ]) . $model->id.' - '.Yii::t('itinfo/app', Yii::$app->controller->module->params['title']);
        /*echo Yii::$app->runAction('inventory/invtlochis/create',['renderType'=>1]);
        return $this->render('view', [
            'model' => $model,
        ]);*/
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                if(isset($model->oldloc) && $model->invt_locationID != $model->oldloc) {

                    $lh = new InvtLochistory();
                    $lh->invt_ID = $model->id;
                    $lh->invt_locID = $model->invt_locationID;
                    $lh->date = date('Y-m-d');
                    $lh->update_by = Yii::$app->user->id;

                    if ($lh->save()) {
                        Yii::$app->getSession()->setFlash('addlochisflsh', [
                            'type' => 'success',
                            'duration' => 4000,
                            'icon' => 'glyphicon glyphicon-ok-circle',
                            'message' => Yii::t('inventory/app', 'เพิ่มประวัติสถานที่ใหม่เรียบร้อย'),
                        ]);
                    } else {
                        Yii::$app->getSession()->setFlash('addlochisflsh', [
                            'type' => 'danger',
                            'duration' => 4000,
                            'icon' => 'glyphicon glyphicon-ok-circle',
                            'message' => Yii::t('inventory/app', 'เพิ่มประวัติสถานที่ไม่ได้'),
                        ]);
                    }
                }
                Yii::$app->getSession()->setFlash('edtflsh', [
                    'type' => 'success',
                    'duration' => 4000,
                    'icon' => 'glyphicon glyphicon-ok-circle',
                    'message' => Yii::t('inventory/app', 'ปรับปรุงสถานที่เรียบร้อย'),
                ]);
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                Yii::$app->getSession()->setFlash('edtflsh', [
                    'type' => 'danger',
                    'duration' => 4000,
                    'icon' => 'glyphicon glyphicon-remove-circle',
                    'message' => Yii::t('inventory/app', 'ปรับปรุงสถานที่ไม่ได้'),
                ]);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $qloc = MainLocation::find()->all();
        $locarray = ArrayHelper::map($qloc, 'id', 'loc_name');

        return $this->render('changelocation', [
            'model' => $model,
            'locarray' => $locarray,
            'full' => 1,
        ]);
    }

    public function actionChangestatus($id)
    {
        $model = $this->findModel($id);

        Yii::$app->view->title = Yii::t('inventory/app', 'ปรับปรุงสถานะ {modelClass}: ', [
                'modelClass' => 'Invt Main',
            ]) . $model->id.' - '.Yii::t('itinfo/app', Yii::$app->controller->module->params['title']);
        /*echo Yii::$app->runAction('inventory/invtlochis/create',['renderType'=>1]);
        return $this->render('view', [
            'model' => $model,
        ]);*/
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                if(isset($model->oldstat) && $model->invt_statID != $model->oldstat) {

                    $sh = new InvtStathistory();
                    $sh->invt_ID = $model->id;
                    $sh->invt_statID = $model->invt_statID;
                    $sh->date = date('Y-m-d');

                    if ($sh->save()) {
                        Yii::$app->getSession()->setFlash('addlochisflsh', [
                            'type' => 'success',
                            'duration' => 4000,
                            'icon' => 'glyphicon glyphicon-ok-circle',
                            'message' => Yii::t('inventory/app', 'ปรับปรุงประวัติสถานะเรียบร้อย'),
                        ]);
                    } else {
                        Yii::$app->getSession()->setFlash('addlochisflsh', [
                            'type' => 'danger',
                            'duration' => 4000,
                            'icon' => 'glyphicon glyphicon-ok-circle',
                            'message' => Yii::t('inventory/app', 'ปรับปรุงประวัติสถานะไม่ได้'),
                        ]);
                    }
                }
                Yii::$app->getSession()->setFlash('edtflsh', [
                    'type' => 'success',
                    'duration' => 4000,
                    'icon' => 'glyphicon glyphicon-ok-circle',
                    'message' => Yii::t('inventory/app', 'ปรับปรุงสถานะเรียบร้อย'),
                ]);
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                Yii::$app->getSession()->setFlash('edtflsh', [
                    'type' => 'danger',
                    'duration' => 4000,
                    'icon' => 'glyphicon glyphicon-remove-circle',
                    'message' => Yii::t('inventory/app', 'ปรับปรุงสถานะไม่ได้'),
                ]);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $qstat = InvtStatus::find()->all();
        $statsarray = ArrayHelper::map($qstat, 'id', 'invt_sname');

        return $this->render('changestatus', [
            'model' => $model,
            'statsarray' => $statsarray,
            'full' => 1,
        ]);
    }

    public function actionChangestat($id)
    {

        $model = $this->findModel($id);
        //$model->invt_ID = $model->id;
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                if(isset($model->oldstat) && $model->invt_statID != $model->oldstat) {

                    $sh = new InvtStathistory();
                    $sh->invt_ID = $model->id;
                    $sh->invt_statID = $model->invt_statID;
                    $sh->date = date('Y-m-d');

                    if ($sh->save()) {
                        Yii::$app->getSession()->setFlash('addlochisflsh', [
                            'type' => 'success',
                            'duration' => 4000,
                            'icon' => 'glyphicon glyphicon-ok-circle',
                            'message' => Yii::t('inventory/app', 'เพิ่มประวัติสถานะใหม่เรียบร้อย'),
                        ]);
                    } else {
                        Yii::$app->getSession()->setFlash('addlochisflsh', [
                            'type' => 'danger',
                            'duration' => 4000,
                            'icon' => 'glyphicon glyphicon-ok-circle',
                            'message' => Yii::t('inventory/app', 'เพิ่มประวัติสถานะใหม่ไม่ได้'),
                        ]);
                    }
                }
                echo 1;
            }else{
                echo 0;
            }

        }else{
            $qstat = InvtStatus::find()->all();
            $statsarray = ArrayHelper::map($qstat, 'id', 'invt_sname');

            return $this->renderAjax('changestatus', [
                'model' => $model,
                'statsarray' => $statsarray,
            ]);
        }
    }

    /**
     * Deletes an existing InvtMain model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        InvtLochistory::deleteAll('invt_ID = '.$id);

		Yii::$app->getSession()->setFlash('edtflsh', [
			'type' => 'success',
			'duration' => 4000,
			'icon' => 'glyphicon glyphicon-ok-circle',
			'message' => Yii::t('inventory/app', 'ลบรายการเรียบร้อย'),
		]);
		

        return $this->redirect(['index']);
    }

    public function actionDuplicate($id){
        $model = $this->loadModel($id); // record that we want to duplicate
        $model->id = null;
        $model->isNewRecord = true;
        if($model->save()){
            //duplicated
        }
    }

    /**
     * Finds the InvtMain model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InvtMain the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InvtMain::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
