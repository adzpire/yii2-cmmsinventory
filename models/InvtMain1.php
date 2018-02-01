<?php

namespace backend\modules\inventory\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use backend\modules\location\models\MainLocation;

/**
 * This is the model class for table "invt_main".
 *
 * @property integer $id
 * @property integer $invt_locationID
 * @property integer $invt_typeID
 * @property integer $invt_bdgttypID
 * @property integer $invt_statID
 * @property string $invt_code
 * @property string $invt_name
 * @property string $invt_brand
 * @property string $invt_detail
 * @property string $invt_image
 * @property integer $invt_ppp
 * @property string $invt_budgetyear
 * @property string $invt_occupyby
 * @property string $invt_note
 * @property integer $invt_contact
 * @property string $invt_buyfrom
 * @property string $invt_buydate
 * @property string $invt_checkindate
 * @property string $invt_guarunteedateend
 * @property string $invt_takeoutdate
 * @property string $created_at
 *
 * @property InvtLochistory[] $invtLochistories
 * @property MainLocation $invtLocation
 * @property InvtType $invtType
 * @property InvtBudgettype $invtBdgttyp
 * @property InvtStatus $invtStat
 * @property InvtStathistory[] $invtStathistories
 */
class InvtMain extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invt_main';
    }

    public function behaviors()
    {
        return [
            //BlameableBehavior::className(),
            TimestampBehavior::className(),
        ];
    }
    public $oldloc;
    public $oldstat;
    public function afterFind(){
        //$this->oldAttributes = $this->attributes;
        $this->oldloc = $this->invt_locationID;
        $this->oldstat = $this->invt_statID;
        return parent::afterFind();
    }

    /*public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($insert){
                //$this->invt_note = 'dddd';
                       }else{
                           //$this->invt_note = 'hhhhh';
                           if(isset($this->oldAttributes['level']) && $this->level != $this->oldAttributes['level']){
                               // The attribute is changed. Do something here...
                           }
                if(isset($this->oldloc) && $this->invt_locationID != $this->oldloc){
                    // The attribute is changed. Do something here...
                    $this->invt_note = 'uuuuuuu';
                }else{
                    $this->invt_note = 'wwwwwwww';
                }
            }
            // ...custom code here...
            return true;
        } else {
            return false;
        }
    }
    public function afterSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($insert){
                //$this->invt_note = 'dddd';
            }else{
                if(isset($this->oldloc) && $this->invt_locationID != $this->oldloc){
                    // The attribute is changed. Do something here...
                    $this->invt_note = 'uuuuuuu';
                }else{
                    $this->invt_note = 'wwwwwwww';
                }
            }
            // ...custom code here...
            return true;
        } else {
            return false;
        }
    }*/

    public $file;
    public $filepath;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invt_locationID', 'invt_statID', 'invt_budgetyear'/*, 'invt_contact', 'invt_buyfrom', 'invt_buydate', 'invt_checkindate', 'invt_guarunteedateend', 'invt_takeoutdate'*/], 'required'],
            [['invt_locationID', 'invt_typeID', 'invt_bdgttypID', 'invt_statID'], 'integer'],
            ['invt_ppp', 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
            [['invt_detail', 'invt_note', 'invt_contact'], 'string'],
            [['invt_budgetyear', 'invt_buydate', 'invt_checkindate', 'invt_guarunteedateend', 'invt_takeoutdate'], 'safe'],
            [['invt_code', 'invt_name', 'invt_brand', 'invt_image', 'invt_occupyby', 'invt_buyfrom'], 'string', 'max' => 255],
            [['invt_locationID'], 'exist', 'skipOnError' => true, 'targetClass' => MainLocation::className(), 'targetAttribute' => ['invt_locationID' => 'id']],
            [['invt_typeID'], 'exist', 'skipOnError' => true, 'targetClass' => InvtType::className(), 'targetAttribute' => ['invt_typeID' => 'id']],
            [['invt_bdgttypID'], 'exist', 'skipOnError' => true, 'targetClass' => InvtBudgettype::className(), 'targetAttribute' => ['invt_bdgttypID' => 'id']],
            [['invt_statID'], 'exist', 'skipOnError' => true, 'targetClass' => InvtStatus::className(), 'targetAttribute' => ['invt_statID' => 'id']],
            [['file'], 'file', 'extensions' => 'png, jpg'],
//            [['invt_code'], 'unique', 'message' => "{attribute} :  ซ้ำแล้วไม่สามารถใช้งานได้. <a href=\"update?id=".self::getKey('"{value}"')."\">อัพเดตรายการนี้</a>" ],
            [['invt_code'], 'checkUnique', 'on' => 'create'],
            [['invt_code'], 'checkUnique', 'on'=>'update', 'when' => function($model){
                return $model->isAttributeChanged('invt_code');
            }],
        ];
    }

    public function checkUnique($attribute, $params, $validator)
    {
        $tmp = self::find()->where(['invt_code'=> $this->invt_code])->one();
        if(count($tmp)>0){
            $validator->addError($this, $attribute, "{attribute} : {value} ซ้ำแล้วไม่สามารถใช้งานได้. <a href=\"update?id=".$tmp->id."\">อัพเดตรายการนี้</a>");
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invt_locationID' => 'สถานที่',
            'invt_typeID' => 'ประเภทพัสดุ',
            'invt_bdgttypID' => 'ประเภทเงิน',
            'invt_statID' => 'สถานะพัสดุ',
            'invt_code' => 'หมายเลขรหัส',
            'invt_name' => 'ชื่อ',
            'invt_brand' => 'ยี่ห้อ',
            'invt_detail' => 'รายละเอียด',
            'invt_image' => 'รูปภาพ',
            'invt_ppp' => 'ราคาต่อหน่วย',
            'invt_budgetyear' => 'ปีงบประมาณ',
            'invt_occupyby' => 'ครอบครองโดย',
            'invt_note' => 'หมายเหตุ',
            'invt_contact' => 'เลขที่สัญญา',
            'invt_buyfrom' => 'บริษัทที่ซื้อ',
            'invt_buydate' => 'วันที่ที่ซื้อ',
            'invt_checkindate' => 'วันที่ตรวจรับ',
            'invt_guarunteedateend' => 'วันสิ้นสุดประกัน',
            'invt_takeoutdate' => 'วันที่เบิกของ',
            'created_at' => 'วันที่บันทึก',
            'file' => 'ไฟล์รูปภาพ',
        ];
    }

    public function upload()
    {
        $defaultImageWidth = 1024;

        if ($this->validate(['file'])) {
            $targetPath = Yii::getAlias('@frontend/web/uploads/inventory_files/');
            $this->filepath = $targetPath .time().'_'. $this->file->baseName . '.' . $this->file->extension;

            $this->file->saveAs($this->filepath);
                /*if($this->isImage($this->filepath)){
                    $image= Yii::$app->image->load($this->filepath);
                    $image->resize($defaultImageWidth);
                    $image->save($this->filepath);
                }*/
            return true;
        } else {
            return false;
        }
    }

    public function getLongdetail()
    {
        return $this->invt_name.' '.$this->invt_brand.' '.$this->invt_detail;
    }

    public function getShortdetail()
    {
        return $this->invt_name.' '.$this->invt_brand;
    }

    public function getConcatened()
    {
        return ' '.$this->invt_name.' '.$this->invt_brand.' ('.$this->invt_code.')';
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvtLochistories()
    {
        return $this->hasMany(InvtLochistory::className(), ['invt_ID' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvtLocation()
    {
        return $this->hasOne(MainLocation::className(), ['id' => 'invt_locationID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvtType()
    {
        return $this->hasOne(InvtType::className(), ['id' => 'invt_typeID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvtBdgttyp()
    {
        return $this->hasOne(InvtBudgettype::className(), ['id' => 'invt_bdgttypID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvtStat()
    {
        return $this->hasOne(InvtStatus::className(), ['id' => 'invt_statID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvtStathistories()
    {
        return $this->hasMany(InvtStathistory::className(), ['invt_ID' => 'id']);
    }
}
