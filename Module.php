<?php

namespace humhub\modules\profilenotify;

use Yii;
use yii\helpers\Url;
use humhub\modules\user\models\Group;
use humhub\modules\profilenotify\notifications\ProfileChanged;

class Module extends \humhub\components\Module
{
    public static function beforeProfileUpdate($event)
    {
        $attr = $event->sender->dirtyAttributes;
        $count = count($attr);
        /* birthday_hide_year always present - hardcoded */
        if(! (isset($attr['birthday_hide_year']) && $count == 1) && $count > 0){
            ProfileChanged::instance()->about($event)->sendBulk(Group::getAdminGroup()->users);
        }
    }

    public function getNotifications()
    {
        if (Yii::$app->user->isAdmin()) {
            return [
                'humhub\modules\profilenotify\notifications\ProfileChanged',
            ];
        }
    }

}
