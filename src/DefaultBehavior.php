<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 21.12.2016
 * Time: 19:36
 */

namespace floor12\defaultbehavior;

use yii\base\Behavior;
use yii\db\ActiveRecord;

class DefaultBehavior extends Behavior
{
    public $create_user_id = 'create_user_id';
    public $update_user_id = 'update_user_id';
    public $created = 'created';
    public $updated = 'updated';

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'fillData',
            ActiveRecord::EVENT_BEFORE_INSERT => 'saveCreator',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'saveUpdator'
        ];
    }

    public function fillData()
    {
        if ($this->owner->isNewRecord)
            $this->owner->{$this->created} = time();
        $this->owner->{$this->updated} = time();
    }

    public function saveCreator()
    {
        if (isset(\Yii::$app->user)) {
            $this->owner->{$this->create_user_id} = \Yii::$app->user->id;
            $this->owner->{$this->update_user_id} = \Yii::$app->user->id;
        }

        $this->owner->{$this->created} = time();
        $this->owner->{$this->updated} = time();
    }

    public function saveUpdator()
    {
        if (isset(\Yii::$app->user))
            $this->owner->{$this->update_user_id} = \Yii::$app->user->id;

        $this->owner->{$this->updated} = time();
    }

}