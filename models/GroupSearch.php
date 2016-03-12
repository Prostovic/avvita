<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Group;

/**
 * GroupSearch represents the model behind the search form about `app\models\Group`.
 */
class GroupSearch extends Group
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['grp_id', 'grp_active', 'grp_order', ], 'integer'],
            [['grp_title', 'grp_imagepath', 'grp_description', 'grp_created'], 'safe'],
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
        $query = Group::find();

        $query->with('goods');

        $aProvider = [
            'query' => $query,
            'sort'=> [
                'defaultOrder' => isset($params['sort']) ? $params['sort'] : ['grp_order' => SORT_ASC]
            ]
        ];

        $dataProvider = new ActiveDataProvider($aProvider);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'grp_id' => $this->grp_id,
            'grp_active' => $this->grp_active,
            'grp_created' => $this->grp_created,
            'grp_order' => $this->grp_order,
        ]);

        $query->andFilterWhere(['like', 'grp_title', $this->grp_title])
            ->andFilterWhere(['like', 'grp_imagepath', $this->grp_imagepath])
            ->andFilterWhere(['like', 'grp_description', $this->grp_description]);

        return $dataProvider;
    }
}
