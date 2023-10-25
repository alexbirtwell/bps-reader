<?php
    return [
        'log' => env('LOG_READINGS', false),
        'mappings' => [
            //source //label
            '16843776' => 'accumulative_flow',
            '16844032' => 'flow',
            '16844544' => 'pressure',
            '16845056' => 'status',
            '16844288' => 'temperature',
            '16847104' => 'standby',
        ],
        'colors' => [
            //source //label
            'accumulative_flow' => '#F85DC6',
            'flow'  => '#7F4CFD',
            'pressure'  => '#40BEE5',
            'status'  => '#CEF217',
            'temperature'  => '#FDCC2E',
            'standby'  => '#EBE007',
        ],
        'modifications' => [
            'accumulative_flow' => fn ($value) => ['*', 10],
            'pressure' => ['/', 100],
            'temperature' => ['/', 10],
        ]
    ];
