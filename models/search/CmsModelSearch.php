<?php

namespace yii2mod\cms\models\search;

use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii2mod\cms\models\CmsModel;

/**
 * Class CmsModelSearch
 * @package yii2mod\cms\models\search
 */
class CmsModelSearch extends CmsModel
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge([
            [['id', 'url', 'title', 'status', 'commentAvailable'], 'safe'],
        ], parent::rules());
    }


    /**
     * Setup search function for filtering and sorting
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = self::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['id' => SORT_DESC],
        ]);


        // load the search form data and validate
        if (!($this->load($params))) {
            return $dataProvider;
        }

        //adjust the query by adding the filters
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['commentAvailable' => $this->commentAvailable]);
        $query->andFilterWhere(['like', 'url', $this->url]);
        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}

    
