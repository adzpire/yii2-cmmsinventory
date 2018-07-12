<?php

namespace backend\modules\inventory\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "invt_hddram".
 *
 
 * @property integer $id
 * @property integer $invt_id
 * @property integer $hdd_exist
 * @property integer $ram_exist
 * @property string $comment
 * @property InvtMain $invt
 */
class InvtHddram extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invt_hddram';
    }

public $invtName; 
/*add rule in [safe]
'invtName', 
join in searh()
$query->joinWith(['invt', ]);*/
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invt_id', 'hdd_exist', 'ram_exist', 'comment'], 'required'],
            [['invt_id', 'hdd_exist', 'ram_exist'], 'integer'],
            [['comment'], 'string'],
            [['invt_id'], 'exist', 'skipOnError' => true, 'targetClass' => InvtMain::className(), 'targetAttribute' => ['invt_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invt_id' => 'สิ่งของ',
            'hdd_exist' => 'ฮาร์ดดิสก์ที่มี',
            'ram_exist' => 'แรมที่มี',
            'comment' => 'ความเห็น',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvt()
    {
        return $this->hasOne(InvtMain::className(), ['id' => 'invt_id']);
		
			/*
			$dataProvider->sort->attributes['invtName'] = [
				'asc' => ['invt_main.name' => SORT_ASC],
				'desc' => ['invt_main.name' => SORT_DESC],
			];
			
			->andFilterWhere(['like', 'invt_main.name', $this->invtName])
			->orFilterWhere(['like', 'invt_main.name1', $this->invtName])

			in grid
			[
				'attribute' => 'invtName',
				'value' => 'invt.name',
				'label' => $searchModel->attributeLabels()['invt_id'],
				'filter' => \InvtMain::invtList,
			],
			*/
    }
	
	public function getInvtList()
    {
        $data = $this->invt;
        $doc = '<ul>';
        foreach($data as $key) {
            $doc .= '<li>'.$key->invt_id.'</li>';
        }
        $doc .= '</ul>';
        return $doc;
    }

public function getInvtHddramList(){
		return ArrayHelper::map(self::find()->all(), 'id', 'title');
	}

/*


public static function itemsAlias($key) {
        $items = [
            'status' => [
                0 => Yii::t('app', 'ร่าง'),
                1 => Yii::t('app', 'เสนอ'),
                2 => Yii::t('app', 'อนุมัติ'),
                3 => Yii::t('app', 'ไม่อนุมัติ'),
                4 => Yii::t('app', 'คืนแล้ว'),
            ],
            'statusCondition'=>[
                1 => Yii::t('app', 'อนุมัติ'),
                0 => Yii::t('app', 'ไม่อนุมัติ'),
            ]
        ];
        return ArrayHelper::getValue($items, $key, []);
    }

    public function getStatusLabel() {
        $status = ArrayHelper::getValue($this->getItemStatus(), $this->status);
        $status = ($this->status === NULL) ? ArrayHelper::getValue($this->getItemStatus(), 0) : $status;
        switch ($this->status) {
            case 0 :
            case NULL :
                $str = '<span class="label label-warning">' . $status . '</span>';
                break;
            case 1 :
                $str = '<span class="label label-primary">' . $status . '</span>';
                break;
            case 2 :
                $str = '<span class="label label-success">' . $status . '</span>';
                break;
            case 3 :
                $str = '<span class="label label-danger">' . $status . '</span>';
                break;
            case 4 :
                $str = '<span class="label label-succes">' . $status . '</span>';
                break;
            default :
                $str = $status;
                break;
        }

        return $str;
    }

    public static function getItemStatus() {
        return self::itemsAlias('status');
    }
    
    public static function getItemStatusConsider() {
        return self::itemsAlias('statusCondition');       
    }
*/
}
