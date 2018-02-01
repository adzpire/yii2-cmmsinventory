<?php

namespace backend\modules\inventory\models;

use Yii;

/**
 * This is the model class for table "invt_stathistory".
 *
 * @property integer $id
 * @property integer $invt_ID
 * @property integer $invt_statID
 * @property string $date
 *
 * @property InvtMain $invt
 * @property InvtStatus $invtStat
 */
class InvtStathistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invt_stathistory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invt_ID', 'invt_statID', 'date'], 'required'],
            [['invt_ID', 'invt_statID'], 'integer'],
            [['date'], 'safe'],
            [['invt_ID'], 'exist', 'skipOnError' => true, 'targetClass' => InvtMain::className(), 'targetAttribute' => ['invt_ID' => 'id']],
            [['invt_statID'], 'exist', 'skipOnError' => true, 'targetClass' => InvtStatus::className(), 'targetAttribute' => ['invt_statID' => 'id']],
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
            'invt_statID' => 'สถานะ',
            'date' => 'วันที่บันทึก',
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
    public function getInvtStat()
    {
        return $this->hasOne(InvtStatus::className(), ['id' => 'invt_statID']);
    }
}
