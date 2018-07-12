<?php

namespace backend\modules\inventory\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use backend\modules\location\models\MainLocation;
use backend\modules\person\models\Person;
/**
 * This is the model class for table "form_invttake_main".
 *
 
 * @property integer $ID
 * @property integer $staffID
 * @property integer $LocationID
 * @property string $date
 * @property FormInvttakeItems[] $formInvttakeItems
 * @property Person $staff
 * @property MainLocation $location
 */
class FormInvttakeMain extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_invttake_main';
    }

public $formInvttakeItemsName; 
public $staffName; 
public $locationName; 
/*add rule in [safe]
'formInvttakeItemsName', 'staffName', 'locationName', 
join in searh()
$query->joinWith(['formInvttakeItems', 'staff', 'location', ]);*/
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['staffID', 'LocationID', 'date'], 'required'],
            [['staffID', 'LocationID'], 'integer'],
            [['date'], 'safe'],
            [['staffID'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['staffID' => 'user_id']],
            [['LocationID'], 'exist', 'skipOnError' => true, 'targetClass' => MainLocation::className(), 'targetAttribute' => ['LocationID' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'staffID' => 'Staff ID',
            'LocationID' => 'location ID',
            'date' => 'วันที่',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormInvttakeItems()
    {
        return $this->hasMany(FormInvttakeItems::className(), ['finvttakemainID' => 'ID']);
		
			/*
			$dataProvider->sort->attributes['formInvttakeItemsName'] = [
				'asc' => ['form_invttake_main.name' => SORT_ASC],
				'desc' => ['form_invttake_main.name' => SORT_DESC],
			];
			
			->andFilterWhere(['like', 'form_invttake_main.name', $this->formInvttakeItemsName])
			->orFilterWhere(['like', 'form_invttake_main.name1', $this->formInvttakeItemsName])

			in grid
			[
				'attribute' => 'formInvttakeItemsName',
				'value' => 'formInvttakeItems.name',
				'label' => $searchModel->attributeLabels()['finvttakemainID'],
				'filter' => \FormInvttakeItems::formInvttakeItemsList,
			],
			*/
    }
	
	public function getFormInvttakeItemsList()
    {
        $data = $this->formInvttakeItems;
        $doc = '<ul>';
        foreach($data as $key) {
            $doc .= '<li>'.$key->finvttakemainID.'</li>';
        }
        $doc .= '</ul>';
        return $doc;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Person::className(), ['user_id' => 'staffID']);
		
			/*
			$dataProvider->sort->attributes['staffName'] = [
				'asc' => ['person.name' => SORT_ASC],
				'desc' => ['person.name' => SORT_DESC],
			];
			
			->andFilterWhere(['like', 'person.name', $this->staffName])
			->orFilterWhere(['like', 'person.name1', $this->staffName])

			in grid
			[
				'attribute' => 'staffName',
				'value' => 'staff.name',
				'label' => $searchModel->attributeLabels()['staffID'],
				'filter' => \Person::staffList,
			],
			*/
    }
	
	public function getStaffList()
    {
        $data = $this->staff;
        $doc = '<ul>';
        foreach($data as $key) {
            $doc .= '<li>'.$key->staffID.'</li>';
        }
        $doc .= '</ul>';
        return $doc;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(MainLocation::className(), ['id' => 'LocationID']);
		
			/*
			$dataProvider->sort->attributes['locationName'] = [
				'asc' => ['main_location.name' => SORT_ASC],
				'desc' => ['main_location.name' => SORT_DESC],
			];
			
			->andFilterWhere(['like', 'main_location.name', $this->locationName])
			->orFilterWhere(['like', 'main_location.name1', $this->locationName])

			in grid
			[
				'attribute' => 'locationName',
				'value' => 'location.name',
				'label' => $searchModel->attributeLabels()['LocationID'],
				'filter' => \MainLocation::locationList,
			],
			*/
    }
	
	public function getLocationList()
    {
        $data = $this->location;
        $doc = '<ul>';
        foreach($data as $key) {
            $doc .= '<li>'.$key->LocationID.'</li>';
        }
        $doc .= '</ul>';
        return $doc;
    }

public function getFormInvttakeMainList(){
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
