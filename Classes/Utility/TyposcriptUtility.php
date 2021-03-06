<?php

namespace MoveElevator\MeCleverreach\Utility;

use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Exception;

/**
 * Class TyposcriptUtility
 *
 * @package MoveElevator\MeCleverreach\Utility
 */
class TyposcriptUtility
{

    /**
     * Gets TS for a plugin
     *
     * @param string $pluginKey (e.q. tx_metimeline)
     * @param string $typoscriptKey (e.q. settings)
     *
     * @return array|bool
     * @throws \TYPO3\CMS\Extbase\Exception
     */
    public static function getTypoScriptSetup($pluginKey, $typoscriptKey = '')
    {
        $objectManager = new ObjectManager();
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $typoScript = $configurationManager->getConfiguration('FullTypoScript');

        if (!is_array($typoScript['plugin.'][$pluginKey . '.'])) {
            throw new Exception('no typoscript setup for plugin.' . $pluginKey, 1352897029);
        }

        if (empty($typoscriptKey)) {
            return $typoScript['plugin.'][$pluginKey . '.'];
        }

        if (!is_null($typoScript['plugin.'][$pluginKey . '.'][$typoscriptKey . '.'])) {
            return $typoScript['plugin.'][$pluginKey . '.'][$typoscriptKey . '.'];
        }

        if (!is_null($typoScript['plugin.'][$pluginKey . '.'][$typoscriptKey])) {
            return $typoScript['plugin.'][$pluginKey . '.'][$typoscriptKey];
        }

        throw new Exception(
            'no typoscript setup for plugin.' . $pluginKey . ' and typoscript key ' . $typoscriptKey,
            1357206457
        );
    }
}
