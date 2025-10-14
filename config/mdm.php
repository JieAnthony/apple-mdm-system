<?php

return [
    'host' => env('MDM_HOST'),
    'enrollment_host' => env('MDM_ENROLLMENT_HOST'),
    'username' => env('MDM_USERNAME'),
    'password' => env('MDM_PASSWORD'),

    'bundle' => [
        'main' => env('MDM_BUNDLE_ID', 'com.dev.mdm'),
        'restriction' => env('MDM_BUNDLE_ID', 'com.dev.mdm').'ForRestrictions',
    ],
];
