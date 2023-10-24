<?php
    return [
        'log' => env('LOG_READINGS', false),
        'mappings' => [
            //source //label
            '16844032' => 'accumulative_flow',
            '16843776' => 'flow',
            '16844544' => 'pressure',
            '16845056' => 'status',
            '16844288' => 'temperature',
            '16847104' => 'standby',
        ]
    ];
