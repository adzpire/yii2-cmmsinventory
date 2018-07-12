<?php

namespace backend\modules\inventory\controllers;
use Yii;
use backend\modules\inventory\models\InvtMainSearch;
use backend\modules\inventory\models\InvtMain;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;
/**
 * Default controller for the `inventory` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        Yii::$app->view->title = ' หน้าหลักระบบข้อมูลพัสดุ/ครุภัณฑ์';
        return $this->render('index');
    }
    public function actionQrfind()
    {
        Yii::$app->view->title = ' หา QR code';
        $session = Yii::$app->session;
        // print_r($session['qritem']);exit();
        if ($session->has('qritem')){
            $searchModel = InvtMain::find()->where(['id' => $session['qritem']]);
            $dataProvider = new ActiveDataProvider([
                'query' => $searchModel,
                // 'pagination' => [
                //     'pageSize' => 10,
                // ],
                // 'sort' => [
                //     'defaultOrder' => [
                //         'created_at' => SORT_DESC,
                //         'title' => SORT_ASC, 
                //     ]
                // ],
            ]);
        }else{
            $searchModel = new InvtMainSearch();
            if(!Yii::$app->request->queryParams){
            $param['InvtMainSearch']['id'] = '0';
            // พี่บ่าวลองเปลี่ยนดู มันได้ แต่มันโผล่ abcd ที่ textbox ลองเปลี่ยน searching เป็นฟิลด์อื่นที่ไม่เกี่ยวข้องกับการค้นหาหน้าเว็บดู
            }else{
                $param = Yii::$app->request->queryParams;
            }
            $dataProvider = $searchModel->search($param);
        }          
        return $this->render('qrfind', [
            'searchModel' => (!$session->has('qritem')) ? $searchModel : false,
            'dataProvider' => $dataProvider,
            'qritem' => $session['qritem'],
        ]);
    }
    public function actionSelitem()
    {
        $session = Yii::$app->session;
        // var_dump($session);exit();
        Yii::$app->view->title = ' เลือกเพื่อสร้าง QR code';
        $searchModel = new InvtMainSearch();
        if(!Yii::$app->request->queryParams){
            $param['InvtMainSearch']['id'] = '0';
            // พี่บ่าวลองเปลี่ยนดู มันได้ แต่มันโผล่ abcd ที่ textbox ลองเปลี่ยน searching เป็นฟิลด์อื่นที่ไม่เกี่ยวข้องกับการค้นหาหน้าเว็บดู
        }else{
            $param = Yii::$app->request->queryParams;
        }
        $dataProvider = $searchModel->search($param);

        return $this->render('selitem', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'qritem' => $session['qritem'],
        ]);
    }
    public function actionAddsession()
    {
        $post = Yii::$app->request->post();
        $pk = $post['row_id'];
        $session = Yii::$app->session;
        // if ($session->has('qritem')){
        //     array_push($_SESSION['qritem'][], $pk);
        //     $_SESSION['qritem'][] =  $pk;
        // }
        // $session->set('qritem', $pk);
        if (!$session->has('qritem')){
            foreach($post['row_id'] as $key => $value){
                $_SESSION['qritem'][] =  $value;
            }
        }else{
            foreach($post['row_id'] as $key => $value){
                array_push($_SESSION['qritem'], $value);
            }
        }
        // $_SESSION['qritem'][] =  $pk;
        // array_push($_SESSION['qritem'], $pk);
        return '';
    }
    public function actionDelsession()
    {
        $session = Yii::$app->session;
        if ($session->has('qritem')){
            $session->remove('qritem');
        }
        return '';
    }
    public function actionQrproc($id)
    {
        return $this->render('qrproc', [
            'id' => $id,
        ]);
    }
    public function actionReadme()
    {
        return $this->render('readme');
    }
    public function actionChangelog()
    {
        return $this->render('changelog');
    }
    public function actionSetvercookies()
    {
        $cookie = \Yii::$app->response->cookies;
        $cookie->add(new \yii\web\Cookie([
            'name' => \Yii::$app->controller->module->params['modulecookies'],
            'value' => \Yii::$app->controller->module->params['ModuleVers'],
            'expire' => time() + (60*60*24*30),
        ]));
        $this->redirect(Url::previous());
    }
    /*************
     * select2 ajax
     ************/
    public function actionInvtlist($q = null, $id = null)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new \yii\db\Query;

            $query->select(['id', new \yii\db\Expression("CONCAT(`invt_name`, ' brand: ', `invt_brand`, ' code: ', `invt_code`) as text")])
                ->from('invt_main')
                ->where(['like', 'invt_name', $q])
                ->orWhere(['like', 'invt_code', $q])
                ->orWhere(['like', 'invt_brand', $q]);
            //->limit(20)
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => InvtMain::find($id)->invt_name];
        }
        return $out;
    }
}
