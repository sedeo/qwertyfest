<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * InformesSearch represents the model behind the search form of `app\models\Informes`.
 */
class InformesSearch extends Informes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'recibe_id', 'envia_id'], 'integer'],
            [['motivo', 'descripcion', 'created_at', 'recibe.nombre', 'envia.nombre'], 'safe'],
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

    public function attributes()
    {
        return array_merge(parent::attributes(), ['recibe.nombre', 'envia.nombre']);
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Informes::find()->joinWith(['recibe']); // Por revisar

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

        $dataProvider->sort->attributes['recibe.nombre'] = [
            'asc' => ['usuarios.nombre' => SORT_ASC],
            'desc' => ['usuarios.nombre' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['envia.nombre'] = [
            'asc' => ['usuarios.nombre' => SORT_ASC],
            'desc' => ['usuarios.nombre' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'recibe_id' => $this->recibe_id,
            'envia_id' => $this->envia_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['ilike', 'motivo', $this->motivo])
            ->andFilterWhere(['ilike', 'descripcion', $this->descripcion])
            ->andFilterWhere(['ilike', 'usuarios.nombre', $this->getAttribute('recibe.nombre')])
            ->andFilterWhere(['ilike', 'usuarios.nombre', $this->getAttribute('envia.nombre')]);

        return $dataProvider;
    }
}
