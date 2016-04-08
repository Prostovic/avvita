<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Good;
use app\models\Goodgroup;

/**
 * GoodSearch represents the model behind the search form about `app\models\Good`.
 */
class GoodSearch extends Good
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gd_id', 'gd_number', 'gd_active', 'groupid', ], 'integer'],
            [['gd_title', 'gd_imagepath', 'gd_description', 'gd_created'], 'safe'],
            [['gd_price'], 'number'],
            [['_ordered'], 'save'],
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
        $query = Good::find()->with(['images', 'groups']);
        $subQuery = Orderitem::find()
            ->select('ordit_gd_id, SUM(ordit_count) as ordered')
            ->groupBy('ordit_gd_id');

//        Yii::info('params = ' . print_r($params, true));
        $query->leftJoin(['goodCount' => $subQuery], 'goodCount.ordit_gd_id = gd_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if( !empty($this->groupid) ) {
            $sFld = Goodgroup::tableName() . '.gdgrp_gd_id';
            $query->join('INNER JOIN', Goodgroup::tableName(), $sFld . ' = gd_id');
            $query->andFilterWhere([
                Goodgroup::tableName() . '.gdgrp_grp_id' => $this->groupid,
            ]);
        }

        $query->andFilterWhere([
            'gd_id' => $this->gd_id,
            'gd_price' => $this->gd_price,
            'gd_number' => $this->gd_number,
            'gd_active' => self::GOOD_ACTIVE_FLAG,
            'gd_created' => $this->gd_created,
        ]);

        $query->andFilterWhere(['like', 'gd_title', $this->gd_title])
            ->andFilterWhere(['like', 'gd_imagepath', $this->gd_imagepath])
            ->andFilterWhere(['like', 'gd_description', $this->gd_description]);

        return $dataProvider;
    }
}
