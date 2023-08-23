<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FundTicket;

/**
 * FundTicketSearch represents the model behind the search form of `app\models\FundTicket`.
 */
class FundTicketSearch extends FundTicket
{

    public $member;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_member', 'credit', 'debet', 'id_fund_ref', 'id_member_ref'], 'integer'],
            [['id_trx', 'date_created'], 'safe'],
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

    public function getQuerySearch($params)
    {
        $query = FundTicket::find();

        $this->load($params);

        // add conditions that should always apply here

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_member' => $this->id_member,
            'credit' => $this->credit,
            'debet' => $this->debet,
            'id_fund_ref' => $this->id_fund_ref,
            'id_member_ref' => $this->id_member_ref,
            'date_created' => $this->date_created,
        ]);

        $query->andFilterWhere(['like', 'id_trx', $this->id_trx]);

        if ($this->member != null) {
            $query->andFilterWhere(['id_member' => $this->member])->orFilterWhere(['id_member_ref' => $this->member]);
            // $command = $query->createCommand()->getRawSql();
            // var_dump($command); die();
        }

        return $query;
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
        $query = $this->getQuerySearch($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }
}
