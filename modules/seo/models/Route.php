<?php

namespace modules\seo\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class Route
 * @package modules\seo\models
 * Saved urls
 * @property integer $id ID
 * @property string $url Url
 * @property string $route Route
 * @property integer $created_at Created at
 * @property integer $updated_at Updated at
 */
class Route extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%route}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestampBehavior' => [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['url', 'string', 'max' => 100],
            ['route', 'string', 'max' => 50],
            ['params', 'string', 'max' => 500],
            [['url', 'route'], 'required'],
            [['url'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'created_at' => 'Created at',
            'updated_at' => 'Updated at'
        ];
    }

    /**
     * Get route by match url
     *
     * @param string  $url
     * @return mixed
     */
    public static function findRouteByUrl($url)
    {
        $query = self::find()
            ->where(['url' => $url])
            ->one();

        return $query;
    }

    /**
     * Create user url
     *
     * @param string $url Url
     * @param string $route Route
     * @return boolean
     */
    public static function saveUrl($url, $route)
    {
        $_route = new Route();
        $_route->url = $url;
        $_route->route = $route;
        if($_route->save(false)){
            return true;
        }
        return false;
    }

}