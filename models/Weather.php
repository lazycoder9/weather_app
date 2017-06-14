<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property string $code
 * @property string $name
 * @property integer $population
 */
class Weather extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'weather';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time', 'day', 'temp'], 'required'],
            [['time'], 'integer'],
            [['day'], 'string', 'max' => 12],
            [['temp'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'time' => 'Time',
            'day' => 'Day',
            'temp' => 'Temperature',
        ];
    }
}
