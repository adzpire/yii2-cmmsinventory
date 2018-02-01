<?php

namespace backend\modules\inventory\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "invt_budgettype".
 *
 * @property integer $id
 * @property string $invt_bname
 * @property string $invt_bdetail
 *
 * @property InvtMain[] $invtMains
 */
class InvtBudgettype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invt_budgettype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invt_bname'], 'required'],
            [['invt_bdetail'], 'string'],
            [['invt_bname'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invt_bname' => 'ชื่อ',
            'invt_bdetail' => 'รายละเอียด',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvtMains()
    {
        return $this->hasMany(InvtMain::className(), ['invt_bdgttypID' => 'id']);
    }
    public static function getBudgetList(){
        return ArrayHelper::map(self::find()->all(), 'id', 'invt_bname');
    }
}
