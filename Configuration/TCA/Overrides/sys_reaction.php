<?php

use WapplerSystems\ComposerReactions\Reaction\ComposerUpdateReaction;


defined('TYPO3') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'sys_reaction',
    'reaction_type',
    [
        'label' => ComposerUpdateReaction::getDescription(),
        'value' => ComposerUpdateReaction::getType(),
        'icon' => ComposerUpdateReaction::getIconIdentifier(),
    ]
);
