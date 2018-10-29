<?php

return [

    'search'          => [
        'case_insensitive' => true,
        'use_wildcards'    => true,
    ],

    'fractal'         => [
        'serializer' => 'League\Fractal\Serializer\DataArraySerializer',
    ],

    'script_template' => 'datatables::script',
];
