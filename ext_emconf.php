<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Composer Reactions',
    'description' => '',
    'category' => 'misc',
    'constraints' => [
        'depends' => [],
        'conflicts' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'WapplerSystems\\ComposerReactions\\' => 'Classes',
        ],
    ],
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'Christian Volkmann',
    'author_email' => 'volkmann@wappler.systems',
    'author_company' => 'WapplerSystems',
    'version' => '1.0.1',
];
