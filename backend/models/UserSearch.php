<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Person;

/**
 * UserSearch represents the model behind the search form of `common\models\User`.
 */
class UserSearch extends Person
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status_id', 'sex', 'created_at', 'updated_at', 'deleted'], 'integer'],
            [['email', 'password', 'name', 'auth_key', 'verification_token'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Person::find();
        $query->where(['deleted' => Person::NOT_DELETED, 'type_is' => Person::TYPE_PERSON]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'status_id' => $this->status_id,
            'sex' => $this->sex,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
              ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
