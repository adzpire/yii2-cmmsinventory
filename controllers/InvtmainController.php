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
use backend\components\AdzpireComponent;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

use yii\filters\VerbFilter;

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

use yii\data\ArrayDataProvider;
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

    public $moduletitle;
    public function beforeAction(){
        $this->moduletitle = Yii::t('app', Yii::$app->controller->module->params['title']);
        return true;
    }
    /**
     * Lists all InvtMain models.
     * @return mixed
     */
    public function actionIndex()
    {
		 
		 Yii::$app->view->title = 'รายการครุภัณฑ์หลัก - '.$this->moduletitle;
		 
        $searchModel = new InvtMainSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $filterS = InvtStatus::getStatusList();
        //$filterBt = InvtBudgettype::getBudgetList();
        $filterT = InvtType::getTypeList();
        $filterL = MainLocation::getLocationList();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'filterT' => $filterT,
            'filterS' => $filterS,
            'filterL' => $filterL,
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
        Yii::$app->view->title = 'รายละเอียด : '.$model->id.' - '.$this->moduletitle;
		 
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
		 Yii::$app->view->title = 'สร้างใหม่ - '.$this->moduletitle;
		 
        $model = new InvtMain(['scenario' => 'create']);

        /* if enable ajax validate*/
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if (Yii::$app->request->isPost) {

            $model->file = UploadedFile::getInstance($model, 'file');
            if(isset($model->file)){
                if ($model->upload()) {
                    AdzpireComponent::succalert('addfile', 'อัพโหลดไฟล์เรียบร้อย');
                }else{
                    AdzpireComponent::dangalert('addfile', 'อัพโหลดไฟล์ไม่ได้');
                }

            }

        }

        if ($model->load(Yii::$app->request->post())) {
			if($model->save()){

//                $lh = new InvtLochistory();
//                $lh->invt_ID = $model->id;
//                $lh->invt_locID = $model->invt_locationID;
//                $lh->date = date('Y-m-d');
//                $lh->update_by = Yii::$app->user->id;
//
//                if ($lh->save()) {
//                    Yii::$app->getSession()->setFlash('addlochisflsh', [
//                        'type' => 'success',
//                        'duration' => 4000,
//                        'icon' => 'glyphicon glyphicon-ok-circle',
//                        'message' => Yii::t('inventory/app', 'เพิ่มประวัติสถานที่เรียบร้อย'),
//                    ]);
//                } else {
//                    Yii::$app->getSession()->setFlash('addlochisflsh', [
//                        'type' => 'danger',
//                        'duration' => 4000,
//                        'icon' => 'glyphicon glyphicon-ok-circle',
//                        'message' => Yii::t('inventory/app', 'เพิ่มประวัติสถานที่ไม่ได้'),
//                    ]);
//                }
//
//                $sh = new InvtStathistory();
//                $sh->invt_ID = $model->id;
//                $sh->invt_statID = $model->invt_statID;
//                $sh->date = date('Y-m-d');
//
//                if ($sh->save()) {
//                    Yii::$app->getSession()->setFlash('addstashisflsh', [
//                        'type' => 'success',
//                        'duration' => 4000,
//                        'icon' => 'glyphicon glyphicon-ok-circle',
//                        'message' => Yii::t('inventory/app', 'เพิ่มประวัติสถานะเรียบร้อย'),
//                    ]);
//                } else {
//                    Yii::$app->getSession()->setFlash('addatathisflsh', [
//                        'type' => 'danger',
//                        'duration' => 4000,
//                        'icon' => 'glyphicon glyphicon-ok-circle',
//                        'message' => Yii::t('inventory/app', 'เพิ่มประวัติสถานะไม่ได้'),
//                    ]);
//                }

                AdzpireComponent::succalert('addflsh', 'เพิ่มเรียบร้อย');
                if(isset(Yii::$app->request->post()['save&go']))
                {
                    return $this->redirect(['create', 'id' => $model->id]);
                }else{
                    return $this->redirect(['view', 'id' => $model->id]);
                }
			}else{
                AdzpireComponent::dangalert('addflsh', 'เพิ่มไม่ได้');
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

        //$model->invt_ppp = 0;
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
        //['scenario' => 'create']
        $model->scenario = 'update';
        Yii::$app->view->title = Yii::t('inventory/app', 'ปรับปรุงรายการ {modelClass}: ', [
    'modelClass' => 'Invt Main',
]) . $model->id.' - '.$this->moduletitle;


        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if (Yii::$app->request->isPost) {

            $model->file = UploadedFile::getInstance($model, 'file');
            if(isset($model->file)){
                if ($model->upload()) {
                    $model->invt_image = basename($model->filepath);
                    AdzpireComponent::succalert('addfile', 'อัพโหลดไฟล์เรียบร้อย');
                }else{
                    AdzpireComponent::dangalert('addfile', 'อัพโหลดไฟล์ไม่ได้');
                }

            }

        }

        if ($model->load(Yii::$app->request->post())) {
			if($model->save()){
                AdzpireComponent::succalert('edtflsh', 'ปรับปรุงรายการเรียบร้อย');
			return $this->redirect([isset(Yii::$app->request->post()['save&go']) ? 'create' : 'view', 'id' => $model->id]);
			}else{
                AdzpireComponent::dangalert('edtflsh', 'ปรับปรุงรายการไม่ได้');
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
                        AdzpireComponent::succalert('addlochisflsh', 'เพิ่มประวัติสถานที่เรียบร้อย');
                    } else {
                        AdzpireComponent::dangalert('addlochisflsh', 'เพิ่มประวัติสถานที่ไม่ได้');
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
                        AdzpireComponent::succalert('addlochisflsh', 'เพิ่มประวัติสถานที่เรียบร้อย');
                    } else {
                        AdzpireComponent::dangalert('addlochisflsh', 'เพิ่มประวัติสถานที่ไม่ได้');
                    }
                }
                AdzpireComponent::succalert('edtflsh', 'ปรับปรุงสถานที่เรียบร้อย');
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                AdzpireComponent::dangalert('edtflsh', 'ปรับปรุงสถานที่ไม่ได้');
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
                        AdzpireComponent::succalert('addstathisflsh', 'ปรับปรุงประวัติสถานะเรียบร้อย');
                    } else {
                        AdzpireComponent::dangalert('addstathisflsh', 'ปรับปรุงประวัติสถานะไม่ได้');
                    }
                }
                AdzpireComponent::succalert('edtflsh', 'ปรับปรุงสถานะเรียบร้อย');
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                AdzpireComponent::dangalert('edtflsh', 'ปรับปรุงสถานะไม่ได้');
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
                        AdzpireComponent::succalert('addstathisflsh', 'เพิ่มประวัติสถานะใหม่เรียบร้อย');
                    } else {
                        AdzpireComponent::dangalert('addstathisflsh', 'เพิ่มประวัติสถานะใหม่ไม่ได้');
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

        AdzpireComponent::succalert('edtflsh', 'ลบรายการเรียบร้อย');

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

    public function actionSearchcode($id){
        $model = InvtMain::find()->where(['like', 'invt_code', $id])->limit(10)->select('invt_code')->distinct()->all();
        $row_set = [];
        foreach ($model as $row)
        {
            $row_set[] = $row['invt_code']; //build an array
        }
        echo json_encode($row_set); //format the array into json data
    }
    public function actionSearchbrand($id){
        $model = InvtMain::find()->where(['like', 'invt_brand', $id])->limit(10)->select('invt_brand')->distinct()->all();
        $row_set = [];
        foreach ($model as $row)
        {
            $row_set[] = $row['invt_brand']; //build an array
        }
        echo json_encode($row_set); //format the array into json data
    }
    public function actionSearchoccupyby($id){
        $model = InvtMain::find()->where(['like', 'invt_occupyby', $id])->limit(10)->select('invt_occupyby')->distinct()->all();

        $row_set = [];
        foreach ($model as $row)
        {
            $row_set[] = $row['invt_occupyby']; //build an array
        }
        echo json_encode($row_set); //format the array into json data
    }
    public function actionSearchname($id){
        $model = InvtMain::find()->where(['like', 'invt_name', $id])->limit(10)->select('invt_name')->distinct()->all();

        $row_set = [];
        foreach ($model as $row)
        {
            $row_set[] = $row['invt_name']; //build an array
        }
        echo json_encode($row_set); //format the array into json data
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

    public function actionCreatebatch()
    {
        Yii::$app->view->title = 'สร้างรายการจำนวนมาก';

        if(isset(Yii::$app->request->post()['genid']))
        {
            $tmplt = Yii::$app->request->post()['template'];
            $num = Yii::$app->request->post()['genid'];

            //print_r($provider);exit();
            //return $this->redirect('batchcheck', [
            //    'template' => $tmplt,
            //    'num' => $num,
            //]);
            return $this->redirect(['batchcheck', 'template' => $tmplt, 'num' => $num,
            ]);
        }
        return $this->render('createbatch');
    }

    public function actionBatchcheck($template, $num)
    {

        Yii::$app->view->title = 'check duplicate';

        $model = new InvtMain(['scenario' => 'create']);

        $tmparr0 =[];
        $tmptext = explode("*",$template);
        for($i =1; $i <= $num; $i++){
            $tmparr2 = ['id'=> join($i.'/'.$num,$tmptext)];
            array_push($tmparr0 , $tmparr2);
        }
        $inventoryarray = InvtMain::find()->select('id, invt_code')
            ->asArray()
            ->all();
        //print_r($inventoryarray); //exit();
        $tmparr = [];
        foreach ($inventoryarray as $key => $value){
            //array_push($tmparr['id'] , $value['invt_code']);
            $tmparr[$value['id']] = $value['invt_code'];
        }

        /* if enable ajax validate*/
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            //
            //echo $model->invt_name;
            $tmpexistarr = [];
            foreach ($inventoryarray as $key => $value){
                array_push($tmpexistarr,$value['invt_code']);
            }
            //print_r($tmpexistarr);
            //echo '<br><br>';
            $tmpcreatarr = [];
//            $arrex = ['วสส.04-223.1.3-1/3-59/ร','วสส.04-223.1.3-2/3-59/ร'];
            foreach($tmparr0 as $key => $value){
//                echo $value['id'].'<br>';
                if (!in_array($value['id'], $tmpexistarr)) {
                    array_push($tmpcreatarr,$value['id']);
                    //echo 'existed';
                }else{
                    //echo 'not existed';
                }
            }

//            print_r($tmpcreatarr);

//                echo $model->invt_code . '<br>';

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    foreach($tmpcreatarr as $key => $value) {
                        $model = new InvtMain();
                        $model->load(Yii::$app->request->post());
                        $model->invt_code = $value;
                        $model->save();
//                        --
//                        $lh = new InvtLochistory();
//                        $lh->invt_ID = $model->id;
//                        $lh->invt_locID = $model->invt_locationID;
//                        $lh->date = date('Y-m-d');
//                        $lh->update_by = Yii::$app->user->id;
//                        $lh->save();
//                        --
//                        $sh = new InvtStathistory();
//                        $sh->invt_ID = $model->id;
//                        $sh->invt_statID = $model->invt_statID;
//                        $sh->date = date('Y-m-d');
//                        $sh->save();
//                        echo $value.'<br/>';
                    }
                    //--
                    $transaction->commit();
                    AdzpireComponent::succalert('addflsh', 'เพิ่มรายการใหม่เรียบร้อย');
                    return $this->redirect(['index']);
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }

//                if($model->save()){
//
//                    /**/
//                    $lh = new InvtLochistory();
//                    $lh->invt_ID = $model->id;
//                    $lh->invt_locID = $model->invt_locationID;
//                    $lh->date = date('Y-m-d');
//                    $lh->update_by = Yii::$app->user->id;
//
//                    if ($lh->save()) {
//                        Yii::$app->getSession()->setFlash('addlochisflsh', [
//                            'type' => 'success',
//                            'duration' => 4000,
//                            'icon' => 'glyphicon glyphicon-ok-circle',
//                            'message' => Yii::t('inventory/app', 'เพิ่มประวัติสถานที่เรียบร้อย'),
//                        ]);
//                    } else {
//                        Yii::$app->getSession()->setFlash('addlochisflsh', [
//                            'type' => 'danger',
//                            'duration' => 4000,
//                            'icon' => 'glyphicon glyphicon-ok-circle',
//                            'message' => Yii::t('inventory/app', 'เพิ่มประวัติสถานที่ไม่ได้'),
//                        ]);
//                    }
//
//                    $sh = new InvtStathistory();
//                    $sh->invt_ID = $model->id;
//                    $sh->invt_statID = $model->invt_statID;
//                    $sh->date = date('Y-m-d');
//
//                    if ($sh->save()) {
//                        Yii::$app->getSession()->setFlash('addstashisflsh', [
//                            'type' => 'success',
//                            'duration' => 4000,
//                            'icon' => 'glyphicon glyphicon-ok-circle',
//                            'message' => Yii::t('inventory/app', 'เพิ่มประวัติสถานะเรียบร้อย'),
//                        ]);
//                    } else {
//                        Yii::$app->getSession()->setFlash('addatathisflsh', [
//                            'type' => 'danger',
//                            'duration' => 4000,
//                            'icon' => 'glyphicon glyphicon-ok-circle',
//                            'message' => Yii::t('inventory/app', 'เพิ่มประวัติสถานะไม่ได้'),
//                        ]);
//                    }
//
//                    Yii::$app->getSession()->setFlash('addflsh', [
//                        'type' => 'success',
//                        'duration' => 4000,
//                        'icon' => 'glyphicon glyphicon-ok-circle',
//                        'message' => Yii::t('inventory/app', 'เพิ่มรายการใหม่เรียบร้อย'),
//                    ]);
//                    if(isset(Yii::$app->request->post()['save&go']))
//                    {
//                        return $this->redirect(['create', 'id' => $model->id]);
//                    }else{
//                        return $this->redirect(['view', 'id' => $model->id]);
//                    }
//                }else{
//                    Yii::$app->getSession()->setFlash('addflsh', [
//                        'type' => 'danger',
//                        'duration' => 4000,
//                        'icon' => 'glyphicon glyphicon-remove-circle',
//                        'message' => Yii::t('inventory/app', 'เพิ่มรายการไม่ได้'),
//                    ]);
//                }
//                print_r($model->getErrors());exit;

//            }
//            exit();

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

        $provider = new ArrayDataProvider([
            'allModels' => $tmparr0,
            'pagination' => false,
            'sort' => false,
        ]);

        //print_r($tmparr);
        //exit();
        return $this->render('batchcheck', [
            'provider'=>$provider,
            'ivntarr'=>$tmparr,
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
}
