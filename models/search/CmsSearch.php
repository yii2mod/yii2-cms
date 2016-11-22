<?php

namespace yii2mod\cms\models\search;

use yii\data\ActiveDataProvider;
use yii2mod\cms\models\CmsModel;

/**
 * Class CmsSearch
 *
 * @package yii2mod\cms\models\search
 */
class CmsSearch extends CmsModel
{
    /**
     * @var int the default page size
     */
    public $pageSize = 10;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'url', 'title', 'status', 'commentAvailable'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->pageSize,
            ],
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['id' => SORT_DESC],
        ]);

        if (!($this->load($params))) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['commentAvailable' => $this->commentAvailable]);
        $query->andFilterWhere(['like', 'url', $this->url]);
        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
