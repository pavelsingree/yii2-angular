<?php

namespace modules\lease\models\frontend;

use yii\db\ActiveRecord;
use Yii;

/**
 * Class Lease
 * @package modules\lease\models\frontend
 * Lease model.
 *
 * This is the model class for table "{{%lease}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $year
 * @property string $make
 * @property string $model
 * @property string $vin
 * @property integer $miles
 * @property integer $zip
 * @property string $trim
 * @property integer $status_id
 * @property string $url
 * @property integer $created_at
 * @property integer $updated_at
 */

class Lease extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lease}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'year', 'miles', 'zip', 'status_id'], 'integer'],
            [['make'], 'string', 'max' => 100],
            [['model', 'trim', 'url'], 'string', 'max' => 255],
            [['vin'], 'string', 'max' => 17],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'year' => 'Year',
            'make' => 'Make',
            'model' => 'Model',
            'vin' => 'Vin',
            'miles' => 'Miles',
            'zip' => 'Zip',
            'trim' => 'Trim',
            'url' => 'Url',
            'status_id' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestampBehavior' => [
                'class' => yii\behaviors\TimestampBehavior::className(),
            ],
            \modules\autoposting\behaviors\AutopostingBehavior::className(),  // Autoposting behavior
        ];
    }
}
