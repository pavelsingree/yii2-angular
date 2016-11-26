<?php

namespace modules\zipdata\models;

use yii\db\ActiveRecord;
use Yii;

/**
 * Class User
 * @package modules\users\models
 * User model.
 *
 * @property string $city City
 * @property string $state_code State code
 * @property integer $zip Zip
 * @property string $latitude Latitude
 * @property string $longitude Longitude
 * @property string $country Country
 */
class Zip extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%zipdata}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city', 'country'], 'string', 'max' => 50],
            [['latitude', 'longitude'], 'double'],
            ['state_code', 'string', 'max' => 2],
            ['zip', 'integer', 'max' => 5],
            [['city', 'state_code', 'zip'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'city' => 'City',
            'state_code' => 'State abbreviation',
            'zip' => 'ZIP',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'country' => 'Country'
        ];
    }

    /**
     * Search by zip code
     * @param string $zip Zip code
     * @return array Zip
     */
    public static function findOneByZip($zip)
    {
        return self::find()->where(['zip' => $zip])->asArray()->one();
    }

    /**
     * Search by Location
     * @param string $location Location
     * @param string $state State
     * @return array Zip
     */
    public static function findOneByLocation($location, $state)
    {
        return self::find()->where(['city' => $location, 'state_code' => $state])->asArray()->one();
    }

    /**
     * @param $zip_one
     * @param $zip_second
     * @return float|int
     */
    public static function getDistanceBetweenZip($zip_one, $zip_second)
    {
        $zip_one_instance = self::find()->where(['zip' => $zip_one])->one();
        $zip_second_instance = self::find()->where(['zip' =>$zip_second])->one();
        if(!$zip_one_instance || !$zip_second_instance) {
            return 0;
        }
        return floor(self::getDistance($zip_one_instance->latitude, $zip_one_instance->longitude, $zip_second_instance->latitude, $zip_second_instance->longitude, 'M'));
    }

    /**
     * Get distance between zips
     *
     * @param integer $lat1
     * @param integer $lon1
     * @param integer $lat2
     * @param integer $lon2
     * @param string{"K", "N", "M"} $unit Unit M - miles, N - nautical miles, K - kilometers
     * @return float
     */
    private static function getDistance($lat1, $lon1, $lat2, $lon2, $unit)
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

}
