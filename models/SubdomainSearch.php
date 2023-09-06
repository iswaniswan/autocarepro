<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Subdomain;

/**
 * SubdomainSearch represents the model behind the search form of `app\models\Subdomain`.
 */
class SubdomainSearch extends Subdomain
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_member'], 'integer'],
            [['name', 'url'], 'string'],
            [['date_created', 'date_udpated'], 'safe'],
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
        $query = Subdomain::find();

        $this->load($params);

        // add conditions that should always apply here

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_member' => $this->id_member,
            'date_created' => $this->date_created,
            'date_udpated' => $this->date_udpated,
        ]);

        $query->andFilterWhere(['like', 'username', $this->name])
            ->andFilterWhere(['like', 'email', $this->url]);

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
