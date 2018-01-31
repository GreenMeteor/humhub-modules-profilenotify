<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\profilenotify\notifications;

use Yii;
use humhub\modules\user\models\User;
use humhub\modules\notification\targets\BaseTarget;
use humhub\modules\notification\targets\MailTarget;
use humhub\modules\notification\targets\WebTarget;
use humhub\modules\notification\targets\MobileTarget;
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
     * @var int used to sort categories
     */
    public $sortOrder = PHP_INT_MAX;

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
    public function getDefaultSetting(BaseTarget $target)
    {
        if ($target->id === MailNotificationTarget::getId()) {
            return true;
        } elseif ($target->id === WebNotificationTarget::getId()) {
            return true;
        } elseif ($target->id === MobileNotificationTarget::getId()) {
            return true;
        }

        return $target->defaultSetting;
    }

    /**
     * Returns an array of target ids, which are not editable.
     * 
     * @param BaseTarget $target
     */
    public function getFixedSettings()
    {
        return [];
    }

    /**
     * Checks if the given notification target is fixed for this category.
     * 
     * @param type $target
     * @return type
     */
    public function isFixedSetting(BaseTarget $target)
    {
        return in_array($target->id, $this->getFixedSettings());
    }

    /**
     * Determines if this category is visible for the given $user.
     * This can be used if a category is only visible for users with certian permissions.
     * 
     * Note if no user is given this function should return true in most cases, otherwise this
     * category won't be visible in the global notification settings.
     * 
     * @param User $user
     * @return boolean
     */
    public function isVisible(User $user = null)
    {
        return true;
    }
}
