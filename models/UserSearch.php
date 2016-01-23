<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['us_id', 'us_active', 'us_position', 'us_getnews', 'us_getstate'], 'integer'],
            [['us_group'], 'in', 'range' => array_keys(self::getGroups()), ],
            [['us_fam', 'us_name', 'us_otch', 'us_email', 'us_phone', 'us_adr_post', 'us_birth', 'us_pass', 'us_city', 'us_org', 'us_city_id', 'us_org_id', 'us_created', 'us_confirm', 'us_activate'], 'safe'],
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
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
//            'pagination' => [
//                'pageSize' => 5,
//            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'us_id' => $this->us_id,
            'us_active' => $this->us_active,
            'us_birth' => $this->us_birth,
            'us_position' => $this->us_position,
            'us_created' => $this->us_created,
//            'us_confirm' => $this->us_confirm,
//            'us_activate' => $this->us_activate,
//            'us_getnews' => $this->us_getnews,
//            'us_getstate' => $this->us_getstate,
        ]);

        $query->andFilterWhere(['like', 'us_fam', $this->us_fam])
            ->andFilterWhere(['like', 'us_name', $this->us_name])
            ->andFilterWhere(['like', 'us_otch', $this->us_otch])
            ->andFilterWhere(['like', 'us_email', $this->us_email])
            ->andFilterWhere(['like', 'us_phone', $this->us_phone])
            ->andFilterWhere(['like', 'us_adr_post', $this->us_adr_post])
            ->andFilterWhere(['like', 'us_pass', $this->us_pass])
            ->andFilterWhere(['like', 'us_city', $this->us_city])
            ->andFilterWhere(['like', 'us_org', $this->us_org])
            ->andFilterWhere(['like', 'us_city_id', $this->us_city_id])
            ->andFilterWhere(['=', 'us_group', $this->us_group])
            ->andFilterWhere(['like', 'us_org_id', $this->us_org_id]);

        return $dataProvider;
    }
}
