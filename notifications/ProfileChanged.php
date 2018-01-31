<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\profilenotify\notifications;

use Yii;
use yii\bootstrap\Html;
use humhub\modules\user\models\User;
use humhub\modules\notification\components\BaseNotification;
use humhub\modules\profilenotify\notifications\ProfileChangedCategory;

/**
 * ProfileChanged Notification
 *
 * @author denntl
 */
class ProfileChanged extends BaseNotification
{
    /**
     * @inheritdoc
     */
    public $moduleId = "profilenotify";

    /**
     * @inheritdoc
     */
    public $viewName = "profilenotifyAccepted";

    /* 
     * @return \humhub\modules\notification\components\NotificationCategory
     */
    public function getCategory()
    {
        if (!$this->_category) {
            $this->_category = $this->category();
        }
        return $this->_category;
    }

    /**
     *  @inheritdoc
     */
    public function category()
    {
        return new ProfileChangedCategory;
    }

    /**
     *  @inheritdoc
     */
    public function getTitle(User $user)
    {
        return Yii::t('ProfilenotifyModule.base', 'User {displayName} changed Profile', [
            '{displayName}' => $this->originator->getDisplayName()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function html()
    {
        if($this->source->sender == null){
            return Yii::t('ProfilenotifyModule.base', 'User ID {userId} changed Profile', [
                '{userId}' => Html::tag('strong', Html::encode($this->record->user_id))
            ]);
        }
        $changedAtrr = '';
        $attributeLabels = $this->source->sender->attributeLabels();
        foreach ($this->source->sender->dirtyAttributes as $name => $value){
            /* birthday_hide_year always present - hardcoded */
            if($name != 'birthday_hide_year') {
                $oldValue = $this->source->sender->getOldAttribute($name);
                $changedAtrr .= Html::tag('br') .
                    $attributeLabels[$name] . ": $value" .
                    " (" . Yii::t('ProfilenotifyModule.base', 'before') . ": $oldValue)";
            }
        }

        return Yii::t('ProfilenotifyModule.base', 'User {displayName} changed Profile params: {params}', [
            '{displayName}' => Html::tag('strong', Html::encode($this->originator->getDisplayName())),
            '{params}' => $changedAtrr,
        ]);
    }
}

?>
