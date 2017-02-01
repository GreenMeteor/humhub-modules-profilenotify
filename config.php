<?php

use humhub\modules\user\models\Profile;

return [
    'id' => 'profilenotify',
    'class' => 'humhub\modules\profilenotify\Module',
    'namespace' => 'humhub\modules\profilenotify',
    'events' => [
        [
            'class' => Profile::className(),
            'event' => Profile::EVENT_BEFORE_UPDATE,
            'callback' => [
                'humhub\modules\profilenotify\Module',
                'beforeProfileUpdate'
            ]
        ]
    ],
];
?>