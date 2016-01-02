<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Orderitem;

/**
 * OrderitemSearch represents the model behind the search form about `app\models\Orderitem`.
 */
class OrderitemSearch extends Orderitem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ordit_id', 'ordit_ord_id', 'ordit_gd_id', 'ordit_count'], 'integer'],
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
        $query = Orderitem::find();

        $query->with(['ordered']);

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
            'ordit_id' => $this->ordit_id,
            'ordit_ord_id' => $this->ordit_ord_id,
            'ordit_gd_id' => $this->ordit_gd_id,
            'ordit_count' => $this->ordit_count,
        ]);

        return $dataProvider;
    }
}
