<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SalasSearch represents the model behind the search form of `app\models\Salas`.
 */
class SalasSearch extends Salas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'propietario'], 'integer'],
            [['n_max', 'usuarios'], 'number'],
            [['descripcion', 'created_at', 'propietario.nombre', 'n_usuarios'], 'safe'],
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
        return array_merge(parent::attributes(), ['propietario.nombre', 'n_usuarios']);
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
        $query = Salas::find()->joinWith(['propietario']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['usuarios' => SORT_ASC, 'n_max' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $dataProvider->sort->attributes['propietario.nombre'] = [
            'asc' => ['usuarios.nombre' => SORT_ASC],
            'desc' => ['usuarios.nombre' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['n_usuarios'] = [
            'asc' => ['salas.usuarios' => SORT_ASC, 'salas.n_max' => SORT_ASC],
            'desc' => ['salas.usuarios' => SORT_DESC, 'salas.n_max' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'propietario_id' => $this->propietario_id,
            'n_max' => $this->n_max,
            'usuarios' => $this->usuarios,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['ilike', 'descripcion', $this->descripcion])
            ->andFilterWhere(['ilike', 'usuarios.nombre', $this->getAttribute('propietario.nombre')]);

        return $dataProvider;
    }
}
