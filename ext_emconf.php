<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Composer Reactions',
    'description' => 'Adds a reaction type for updating composer packages, configurable via extension settings.',
    'category' => 'services',
    'constraints' => [
        'depends' => [],
        'conflicts' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'WapplerSystems\\ComposerReactions\\' => 'Classes',
        ],
    ],
    'state' => 'beta',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'Christian Volkmann',
    'author_email' => 'volkmann@wappler.systems',
    'author_company' => 'WapplerSystems',
    'version' => '1.0.1',
];
