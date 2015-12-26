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
            [['ud_doc_key'], 'string'],
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

        $oUser = Yii::$app->user;
        if( !$oUser->can(User::GROUP_ADMIN) && !$oUser->can(User::GROUP_OPERATOR) ) {
            $this->ud_us_id = $oUser->identity->us_id;
        }

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

        $query->andFilterWhere(['like', 'ud_doc_key', $this->ud_doc_key]);


        return $dataProvider;
    }
}
