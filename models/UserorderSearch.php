<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Userorder;

/**
 * UserorderSearch represents the model behind the search form about `app\models\Userorder`.
 */
class UserorderSearch extends Userorder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ord_id', 'ord_us_id', 'ord_flag'], 'integer'],
            [['ord_summ'], 'number'],
            [['ord_created'], 'safe'],
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
        $query = Userorder::find();
        $query->with(['items', 'user']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $oUser = Yii::$app->user;
        if( !$oUser->can(User::GROUP_ADMIN) && !$oUser->can(User::GROUP_OPERATOR) ) {
            $this->ord_us_id = $oUser->getId();
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ord_id' => $this->ord_id,
            'ord_us_id' => $this->ord_us_id,
            'ord_summ' => $this->ord_summ,
            'ord_flag' => $this->ord_flag,
            'ord_created' => $this->ord_created,
        ]);

        return $dataProvider;
    }
}
