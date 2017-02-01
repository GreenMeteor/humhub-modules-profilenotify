<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2016 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\profilenotify\notifications;

use Yii;
use yii\bootstrap\Html;
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

    /**
     *  @inheritdoc
     */
    public function getTitle(\humhub\modules\user\models\User $user)
    {
        return Yii::t('ProfilenotifyModule.base', 'User {firstName} changed Profile', [
            '{firstName}' => $this->source->sender->firstname
        ]);
    }

    /**
     *  @inheritdoc
     */
    public function category()
    {
        return new ProfileChangedCategory;
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
        return Yii::t('ProfilenotifyModule.base', 'User {firstName} changed Profile params: {params}', [
            '{firstName}' => Html::tag('strong', Html::encode($this->source->sender->firstname)),
            '{params}' => $changedAtrr,
        ]);
    }
}

?>