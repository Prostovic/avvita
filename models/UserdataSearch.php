<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Userdata;

/**
 * UserdataSearch represents the model behind the search form about `app\models\Userdata`.
 */
class UserdataSearch extends Userdata
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ud_id', 'ud_doc_id', 'ud_us_id'], 'integer'],
            [['ud_created'], 'safe'],
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
        $query = Userdata::find();

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
            'ud_id' => $this->ud_id,
            'ud_doc_id' => $this->ud_doc_id,
            'ud_us_id' => $this->ud_us_id,
            'ud_created' => $this->ud_created,
        ]);

        return $dataProvider;
    }
}
