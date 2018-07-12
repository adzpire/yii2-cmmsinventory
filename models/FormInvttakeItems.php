<?php

namespace backend\modules\dochub\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "form_invttake_items".
 *
 
 * @property integer $ID
 * @property integer $finvttakemainID
 * @property integer $InvtID
 * @property InvtMain $invt
 * @property FormInvttakeMain $finvttakemain
 */
class FormInvttakeItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_invttake_items';
    }

public $invtName; 
public $finvttakemainName; 
/*add rule in [safe]
'invtName', 'finvttakemainName', 
join in searh()
$query->joinWith(['invt', 'finvttakemain', ]);*/
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['finvttakemainID', 'InvtID'], 'required'],
            [['finvttakemainID', 'InvtID'], 'integer'],
            [['InvtID'], 'exist', 'skipOnError' => true, 'targetClass' => InvtMain::className(), 'targetAttribute' => ['InvtID' => 'id']],
            [['finvttakemainID'], 'exist', 'skipOnError' => true, 'targetClass' => FormInvttakeMain::className(), 'targetAttribute' => ['finvttakemainID' => 'ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'finvttakemainID' => 'forminventorytakemainID',
            'InvtID' => 'inventory ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvt()
    {
        return $this->hasOne(InvtMain::className(), ['id' => 'InvtID']);
		
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
				'label' => $searchModel->attributeLabels()['InvtID'],
				'filter' => \InvtMain::invtList,
			],
			*/
    }
	
	public function getInvtList()
    {
        $data = $this->invt;
        $doc = '<ul>';
        foreach($data as $key) {
            $doc .= '<li>'.$key->InvtID.'</li>';
        }
        $doc .= '</ul>';
        return $doc;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinvttakemain()
    {
        return $this->hasOne(FormInvttakeMain::className(), ['ID' => 'finvttakemainID']);
		
			/*
			$dataProvider->sort->attributes['finvttakemainName'] = [
				'asc' => ['form_invttake_main.name' => SORT_ASC],
				'desc' => ['form_invttake_main.name' => SORT_DESC],
			];
			
			->andFilterWhere(['like', 'form_invttake_main.name', $this->finvttakemainName])
			->orFilterWhere(['like', 'form_invttake_main.name1', $this->finvttakemainName])

			in grid
			[
				'attribute' => 'finvttakemainName',
				'value' => 'finvttakemain.name',
				'label' => $searchModel->attributeLabels()['finvttakemainID'],
				'filter' => \FormInvttakeMain::finvttakemainList,
			],
			*/
    }
	
	public function getFinvttakemainList()
    {
        $data = $this->finvttakemain;
        $doc = '<ul>';
        foreach($data as $key) {
            $doc .= '<li>'.$key->finvttakemainID.'</li>';
        }
        $doc .= '</ul>';
        return $doc;
    }

public function getFormInvttakeItemsList(){
		return ArrayHelper::map(self::find()->all(), 'ID', 'title');
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
