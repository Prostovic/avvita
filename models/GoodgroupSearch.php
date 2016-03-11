<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Goodgroup;

/**
 * GoodgroupSearch represents the model behind the search form about `app\models\Goodgroup`.
 */
class GoodgroupSearch extends Goodgroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gdgrp_id', 'gdgrp_gd_id', 'gdgrp_grp_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Goodgroup::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'gdgrp_id' => $this->gdgrp_id,
            'gdgrp_gd_id' => $this->gdgrp_gd_id,
            'gdgrp_grp_id' => $this->gdgrp_grp_id,
        ]);

        return $dataProvider;
    }
}
