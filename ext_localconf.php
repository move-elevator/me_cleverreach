<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin('MoveElevator.' . $_EXTKEY, 'MeCleverReach',
    array('Subscribe' => 'subscribeForm,subscribe'),
    array('Subscribe' => 'subscribeForm,subscribe')
);
