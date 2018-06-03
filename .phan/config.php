<?php

return [
    "target_php_version" => null,
    'directory_list' => [
        'src',
        'vendor/container-interop/container-interop',
        'vendor/psr/container',
        'vendor/symfony/console'
    ],
    "exclude_analysis_directory_list" => [
        'vendor/'
    ],
    'plugins' => [
        'AlwaysReturnPlugin',
        'UnreachableCodePlugin',
        'DollarDollarPlugin',
        'DuplicateArrayKeyPlugin',
        'PregRegexCheckerPlugin',
        'PrintfCheckerPlugin',
    ],
];
