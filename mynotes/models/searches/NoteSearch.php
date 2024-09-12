<?php


namespace app\models\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Note;

class NoteSearch extends Model
{
    public $tag;
    public $content;
    public $sort;

    public function rules()
    {
        return [
            [['tag', 'content', 'sort'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Note::find()->joinWith('tags');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->andWhere('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'tag.name', $this->tag])
            ->andFilterWhere(['like', 'note.content', $this->content]);

        switch ($this->sort) {
            case 'date_asc':
                $query->addOrderBy(['created_at' => SORT_ASC]);
                break;
            case 'date_desc':
                $query->addOrderBy(['created_at' => SORT_DESC]);
                break;
            case 'title_asc':
                $query->addOrderBy(['title' => SORT_ASC]);
                break;
            case 'title_desc':
                $query->addOrderBy(['title' => SORT_DESC]);
                break;
            default:
                $query->addOrderBy(['created_at' => SORT_DESC]);
        }

        return $dataProvider;
    }

    public static function listSortOptions()
    {
        return [
            'title_asc' => 'Title (A-Z)',
            'title_desc' => 'Title (Z-A)',
            'date_asc' => 'Date (ascending)',
            'date_desc' => 'Date (descending)',
        ];
    }
}
