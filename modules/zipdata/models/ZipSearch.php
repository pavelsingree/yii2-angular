<?php

namespace modules\zipdata\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ZipSearch extends Zip
{
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
    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Zip::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $this->load($params);

        if(!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'city' => $this->city,
            'state_code' => $this->state_code,
            'zip' => $this->zip,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'country' => $this->country
        ]);

        $query->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'state_code', $this->state_code])
            ->andFilterWhere(['like', 'zip', $this->zip])
            ->andFilterWhere(['like', 'latitude', $this->latitdude])
            ->andFilterWhere(['like', 'longitude', $this->longitude])
            ->andFilterWhere(['like', 'country', $this->country]);

        return $dataProvider;
    }

}