<?php

namespace MoveElevator\MeCleverreach\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Service\TypoScriptService;

/**
 * Class SettingsUtility
 *
 * @package MoveElevator\MeCleverreach\Utility
 */
class SettingsUtility
{
    /**
     * Get settings from TypoScript and form extension configuration.
     * TypoScript overwrite settings from extension configuration.
     *
     * @return array
     */
    public static function getSettings()
    {
        $settings = array();

        $settingsConfVars = self::getExtensionSettingsByConfVars();
        $settingsTypoScript = self::getExtensionSettingsByTypoScript();
        $settings['config'] = array_merge(
            $settingsConfVars['config'],
            $settingsTypoScript['config']
        );

        return $settings;
    }

    /**
     * @return array
     */
    protected static function getExtensionSettingsByConfVars()
    {
        $settings = array();

        if (
            !isset($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['me_cleverreach'])
            || unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['me_cleverreach']) === false
        ) {
            return $settings;
        }

        return array(
            'config' => unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['me_cleverreach'])
        );
    }

    /**
     * @return array
     */
    protected static function getExtensionSettingsByTypoScript()
    {
        $settings = array();

        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');

        /** @var \TYPO3\CMS\Extbase\Service\TypoScriptService $typoScriptService */
        $typoScriptService = $objectManager->get('TYPO3\CMS\Extbase\Service\TypoScriptService');
        $settings = TyposcriptUtility::getTypoScriptSetup('tx_mecleverreach', 'settings');

        if (is_array($settings) && $typoScriptService instanceof TypoScriptService) {
            $settings = $typoScriptService->convertTypoScriptArrayToPlainArray($settings);
        }

        return $settings;
    }
}
