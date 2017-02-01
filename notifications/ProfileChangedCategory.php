<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2016 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\profilenotify\notifications;

use Yii;
use humhub\modules\notification\components\NotificationCategory;
use humhub\modules\notification\components\NotificationTarget;

/**
 * Description of ProfileChangedCategory
 *
 * @author denntl
 */
class ProfileChangedCategory extends NotificationCategory
{
    /**
     * Category Id
     * @var string
     */
    public $id = 'profilenotify';

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return Yii::t('ProfilenotifyModule.base', 'User Profile Changed Notify');
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return Yii::t('ProfilenotifyModule.base', 'Receive Notifications when user profile was changed.');
    }

    /**
     * @inheritdoc
     */
    public function getDefaultSetting(NotificationTarget $target)
    {
        if ($target->id === \humhub\modules\notification\components\MailNotificationTarget::getId()) {
            return true;
        } else if ($target->id === \humhub\modules\notification\components\WebNotificationTarget::getId()) {
            return true;
        } else if ($target->id === \humhub\modules\notification\components\MobileNotificationTarget::getId()) {
            return true;
        }

        return $target->defaultSetting;
    }
}