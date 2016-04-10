<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Banner;

/**
 * BannerSearch represents the model behind the search form about `app\models\Banner`.
 */
class BannerSearch extends Banner
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bnr_id', 'bnr_active', 'bnr_order'], 'integer'],
            [['bnr_imagepath', 'bnr_group', 'bnr_title', 'bnr_description', 'bnr_created'], 'safe'],
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
        $query = Banner::find();

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
            'bnr_id' => $this->bnr_id,
            'bnr_active' => $this->bnr_active,
            'bnr_created' => $this->bnr_created,
            'bnr_order' => $this->bnr_order,
        ]);

        $query->andFilterWhere(['like', 'bnr_imagepath', $this->bnr_imagepath])
            ->andFilterWhere(['like', 'bnr_group', $this->bnr_group])
            ->andFilterWhere(['like', 'bnr_title', $this->bnr_title])
            ->andFilterWhere(['like', 'bnr_description', $this->bnr_description]);

        return $dataProvider;
    }
}
