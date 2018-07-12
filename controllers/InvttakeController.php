<?php

namespace backend\modules\inventory\controllers;

use Yii;
use backend\modules\inventory\models\FormInvttakeMain;
use backend\modules\inventory\models\FormInvttakeMainSearch;
use backend\modules\inventory\models\FormInvttakeItems;
use backend\modules\inventory\models\FormInvttakeItemsSearch;

use backend\modules\person\models\Person;
use backend\modules\location\models\MainLocation;
use backend\modules\inventory\models\InvtMainTakeSearch;
use backend\modules\inventory\models\InvtMainSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\components\AdzpireComponent;

use yii\web\Response;
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

use kartik\mpdf\Pdf;
/**
 * InvttakeController implements the CRUD actions for FormInvttakeMain model.
 */
class InvttakeController extends Controller
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
     * Lists all FormInvttakeMain models.
     * @return mixed
     */
    public function actionIndex()
    {
		 
		 Yii::$app->view->title = 'รายการ ใบเบิกครุภัณฑ์จากงานพัสดุ - '. $this->moduletitle;
		 
        $searchModel = new FormInvttakeMainSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FormInvttakeMain model.
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
     * Creates a new FormInvttakeMain model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		 Yii::$app->view->title = Yii::t('app', 'สร้างใหม่') .' - '. $this->moduletitle;
		 
        $model = new FormInvttakeMain();

		/* if enable ajax validate
		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}*/
		
        if ($model->load(Yii::$app->request->post())) {
			if($model->save()){
				AdzpireComponent::succalert('addflsh', 'เพิ่มรายการใหม่เรียบร้อย');
				return $this->redirect(['update', 'id' => $model->ID]);
			}else{
				AdzpireComponent::dangalert('addflsh', 'เพิ่มรายการไม่ได้');
			}
            print_r($model->getErrors());exit();
        }

            return $this->render('create', [
                'model' => $model,
                'staff' => Person::getPersonList(),
                'loclist' => MainLocation::getLocationList(),
            ]);
        

    }

    /**
     * Updates an existing FormInvttakeMain model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		 $model = $this->findModel($id);
		 
		 Yii::$app->view->title = 'ปรับปรุงรายการ Form Invttake Main: ' . $model->ID.' - '. $this->moduletitle;
		 
        if ($model->load(Yii::$app->request->post())) {
			if($model->save()){
				AdzpireComponent::succalert('edtflsh', 'ปรับปรุงรายการเรียบร้อย');
			return $this->redirect(['update', 'id' => $model->ID]);
			}else{
				AdzpireComponent::dangalert('edtflsh', 'ปรับปรุงรายการไม่ได้');
			}
            print_r($model->getErrors());exit();
        } 

            return $this->render('update', [
                'model' => $model,
                'staff' => Person::getPersonList(),
                'loclist' => MainLocation::getLocationList(),
            ]);
        

    }

    public function actionDetail($id)
    {
        $model = $this->findModel($id);

        $checkModel = new FormInvttakeItemsSearch(['finvttakemainID'=> $model->ID]);
        $checkdataProvider = $checkModel->search(Yii::$app->request->queryParams);
        $tmparr = [];
        foreach( $checkdataProvider->models as $myModel){
            array_push($tmparr, $myModel->InvtID);
         }
        $searchModel = new InvtMainTakeSearch(['itd'=> $tmparr]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        Yii::$app->view->title = 'ปรับปรุงรายการ Form Invttake Main: ' . $model->ID.' - '. $this->moduletitle;

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                AdzpireComponent::succalert('edtflsh', 'ปรับปรุงรายการเรียบร้อย');
                return $this->redirect(['detail', 'id' => $model->ID]);
            }else{
                AdzpireComponent::dangalert('edtflsh', 'ปรับปรุงรายการไม่ได้');
            }
            print_r($model->getErrors());exit();
        }

        return $this->render('detail', [
            'model' => $model,
            'checkModel' => $checkModel,
            'checkdataProvider' => $checkdataProvider,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);


    }
    public function actionSeladd()
    {
        $post = Yii::$app->request->post();
        $pk = $post['row_id'];
        $id = $post['id'];
        foreach ($pk as $key => $value)
        {
            $model = new FormInvttakeItems();
            $model->finvttakemainID = $id;
            $model->InvtID = $value;
            if(!$model->save()){
                print_r($model->getErrors());exit;
            }
        }
    }
    public function actionDelinvtlist()
    {
        $post = Yii::$app->request->post();
        $pk = $post['row_id'];
        foreach ($pk as $key => $value)
        {
            $model = $this->findModeldetail($value);
            if(!$model->delete()){
                print_r($model->getErrors());exit;
            }
        }
    }
    /**
     * Deletes an existing FormInvttakeMain model.
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
     * Finds the FormInvttakeMain model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FormInvttakeMain the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FormInvttakeMain::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('ไม่พบหน้าที่ต้องการ.');
        }
    }
    protected function findModeldetail($id)
    {
        if (($model = FormInvttakeItems::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('ไม่พบหน้าที่ต้องการ.');
        }
    }

    public function actionPdf($id)
    {

        $model = $this->findModel($id);
        $detailmdl = FormInvttakeItems::find()->where(['finvttakemainID' => $model->ID])->all();

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
            'content' => $this->renderPartial('print', [
                'model' => $model,
                'detailmdl' => $detailmdl,
            ]),
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'options' => [
                'title' => 'แบบฟอร์มขออนุมัติยืมเงินรายได้มหาวิทยาลัย',
                'subject' => 'Generating PDF files via yii2-mpdf extension has never been easy'
            ],
            'cssInline' => '
                body {
                    margin-top: 10px;
                    margin-bottom: 10px;
                    font-size: 20px;
                    line-height: 22px;
                    font-family: "sarabun";
                }
                .pagebreak { page-break-before: always; }
                .tbhead {
                    border-top-style: none;
                    border-right-style: none;
                    border-bottom-style: none;
                    border-left-style: none;
                }
                .tbhead {
                    border-top-style: none;
                    border-right-style: none;
                    border-bottom-style: none;
                    border-left-style: none;
                }
                .tbcontent {
                    border: thin solid #000;
                    vertical-align: top;
                    padding-left: 5px;
                }
                a {
                    display: inline-block;
                    color: #000;
                    line-height: 18px;
                    text-decoration: none;
                    border-bottom: 1px dotted;
                }
                .style6{
                  font-size: 30px;
                }
                .style5{
                  font-size: 25px;
                }
                .style4{
                  font-size: 22px;
                  font-weight: 900;
                }
                .fixpos {
                    position: absolute;
                    right: 300px;
                }               
                table.mytable { border: 1px solid black; border-collapse: collapse;}
                
                .mytable td,
                .mytable th { border: 1px solid black; border-collapse: collapse;}

                @media print {
                    .noprint {
                        display: none;
                    }
                }
            ',
            'methods' => [
                //'SetHeader' => ['Generated By: Krajee Pdf Component||Generated On: ' . date("r")],
                //'SetFooter' => ['|Page {PAGENO}|'],
            ]
        ]);
        return $pdf->render();
    }
}
