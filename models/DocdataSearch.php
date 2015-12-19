<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Docdata;

/**
 * DocdataSearch represents the model behind the search form about `app\models\Docdata`.
 */
class DocdataSearch extends Docdata
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['doc_id', 'doc_org_id', 'doc_number'], 'integer'],
            [['doc_key', 'doc_date', 'doc_ordernum', 'doc_fullordernum', 'doc_title', 'doc_created'], 'safe'],
            [['doc_summ'], 'number'],
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
        $query = Docdata::find();

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
            'doc_id' => $this->doc_id,
            'doc_date' => $this->doc_date,
            'doc_org_id' => $this->doc_org_id,
            'doc_number' => $this->doc_number,
            'doc_summ' => $this->doc_summ,
            'doc_created' => $this->doc_created,
        ]);

        $query->andFilterWhere(['like', 'doc_key', $this->doc_key])
            ->andFilterWhere(['like', 'doc_ordernum', $this->doc_ordernum])
            ->andFilterWhere(['like', 'doc_fullordernum', $this->doc_fullordernum])
            ->andFilterWhere(['like', 'doc_title', $this->doc_title]);

        return $dataProvider;
    }
}
