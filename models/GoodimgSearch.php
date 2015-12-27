<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Goodimg;

/**
 * GoodimgSearch represents the model behind the search form about `app\models\Goodimg`.
 */
class GoodimgSearch extends Goodimg
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gi_id', 'gi_gd_id'], 'integer'],
            [['gi_path', 'gi_title', 'gi_created'], 'safe'],
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
        $query = Goodimg::find();

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
            'gi_id' => $this->gi_id,
            'gi_gd_id' => $this->gi_gd_id,
            'gi_created' => $this->gi_created,
        ]);

        $query->andFilterWhere(['like', 'gi_path', $this->gi_path])
            ->andFilterWhere(['like', 'gi_title', $this->gi_title]);

        return $dataProvider;
    }
}
