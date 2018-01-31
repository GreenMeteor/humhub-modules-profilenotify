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
     * @var NotificationCategory cached category instance 
     */
    protected $_category = null;

    /* 
     * @return NotificationCategory
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
        return null;
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
     * Should be overwritten by subclasses for a html representation of the notification.
     * @return string
     */
    public function html()
    {
        // Only for backward compatibility.
        return $this->getAsHtml();
    }

    /**
     * Use html() instead
     * @deprecated since version 1.2
     */
    public function getAsHtml()
    {
        return null;
    }

}
