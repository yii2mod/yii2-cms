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
    public function rules(): array
    {
        return [
            [['id', 'status', 'comment_available'], 'integer'],
            [['url', 'title'], 'string'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param $params
     *
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = CmsModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->pageSize,
            ],
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['id' => SORT_DESC],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['comment_available' => $this->comment_available]);
        $query->andFilterWhere(['like', 'url', $this->url]);
        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
