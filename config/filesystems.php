<?php

return [
    'default' => 'local',
    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => getcwd() . DIRECTORY_SEPARATOR . env('LOCAL_STORAGE_PATH', 'storage'),
        ],
    ],
];
