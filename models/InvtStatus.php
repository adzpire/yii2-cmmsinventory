<?php

namespace backend\modules\inventory\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "invt_status".
 *
 * @property integer $id
 * @property string $invt_sname
 * @property string $invt_sdetail
 *
 * @property InvtMain[] $invtMains
 * @property InvtStathistory[] $invtStathistories
 */
class InvtStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invt_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invt_sname'], 'required'],
            [['invt_sdetail'], 'string'],
            [['invt_sname'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invt_sname' => 'ชื่อ',
            'invt_sdetail' => 'รายละเอียด',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvtMains()
    {
        return $this->hasMany(InvtMain::className(), ['invt_statID' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvtStathistories()
    {
        return $this->hasMany(InvtStathistory::className(), ['invt_statID' => 'id']);
    }

    public static function getStatusList(){
        return ArrayHelper::map(self::find()->all(), 'id', 'invt_sname');
    }
}
