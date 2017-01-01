<?php

namespace backend\modules\inventory\models;

use Yii;

/**
 * This is the model class for table "invt_type".
 *
 * @property integer $id
 * @property string $invt_tname
 * @property string $invt_tdetail
 *
 * @property InvtMain[] $invtMains
 */
class InvtType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invt_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invt_tname'], 'required'],
            [['invt_tdetail'], 'string'],
            [['invt_tname'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invt_tname' => 'ชื่อ',
            'invt_tdetail' => 'รายละเอียด',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvtMains()
    {
        return $this->hasMany(InvtMain::className(), ['invt_typeID' => 'id']);
    }
}
