<?php

namespace app\models\forms;

use app\models\Note;
use app\models\NoteTag;
use app\models\Tag;
use Yii;
use yii\base\Model;

class NoteForm extends Note
{
    public $tagIds = [];
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            ['title', 'string', 'max' => 255],
            ['content', 'string'],
            ['tagIds', 'each', 'rule' => ['integer']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Title',
            'content' => 'Content',
            'tagIds' => 'Tags',
        ];
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($runValidation && !$this->validate($attributeNames)) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (parent::save($runValidation, $attributeNames)) {
                if ($this->isNewRecord) {
                    foreach ($this->tagIds as $tagId) {
                        $noteTag = new NoteTag(['note_id' => $this->id, 'tag_id' => $tagId]);
                        if (!$noteTag->save()) {
                            $transaction->rollBack();
                            return false;
                        }
                    }
                } else {
                    NoteTag::deleteAll(['note_id' => $this->id]);

                    if (!empty($this->tagIds)) {
                        foreach ($this->tagIds as $tagId) {
                            $noteTag = new NoteTag(['note_id' => $this->id, 'tag_id' => $tagId]);
                            if (!$noteTag->save()) {
                                $transaction->rollBack();
                                return false;
                            }
                        }
                    }
                }

                $transaction->commit();
                return true;
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return false;

    }
}
