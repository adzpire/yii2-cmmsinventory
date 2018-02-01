<?php

namespace backend\modules\inventory\models;

use Yii;
//use mirage\user\models\User;
use backend\modules\location\models\MainLocation;
//use backend\modules\person\models\Person;

/**
 * This is the model class for table "invt_lochistory".
 *
 * @property integer $id
 * @property integer $invt_ID
 * @property integer $invt_locID
 * @property string $date
 * @property integer $update_by
 *
 * @property InvtMain $invt
 * @property MainLocation $invtLoc
 */
class InvtLochistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invt_lochistory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invt_ID', 'invt_locID', 'date', 'update_by'], 'required'],
            [['invt_ID', 'invt_locID', 'update_by'], 'integer'],
            [['date'], 'safe'],
            [['invt_ID'], 'exist', 'skipOnError' => true, 'targetClass' => InvtMain::className(), 'targetAttribute' => ['invt_ID' => 'id']],
            [['invt_locID'], 'exist', 'skipOnError' => true, 'targetClass' => MainLocation::className(), 'targetAttribute' => ['invt_locID' => 'id']],
            [['update_by'], 'exist', 'skipOnError' => true, 'targetClass' => Yii::$app->user->identityClass, 'targetAttribute' => ['update_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invt_ID' => 'ชื่อพัสดุ/ครุภัณฑ์',
            'invt_locID' => 'ชื่อสถานที่',
            'date' => 'วันที่บันทึก',
            'update_by' => 'อัพเดตโดย',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvt()
    {
        return $this->hasOne(InvtMain::className(), ['id' => 'invt_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvtLoc()
    {
        return $this->hasOne(MainLocation::className(), ['id' => 'invt_locID']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdateBy()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'update_by']);
    }
}
