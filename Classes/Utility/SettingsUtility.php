<?php

namespace MoveElevator\MeCleverreach\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use \MoveElevator\MeLibrary\Utility\TyposcriptUtility;
use \TYPO3\CMS\Extbase\Service\TypoScriptService;

/**
 * Class SettingsUtility
 *
 * @package MoveElevator\MeCleverreach\Utility
 */
class SettingsUtility {
	/**
	 * @return array
	 */
	static public function getSettings() {
		/** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
		$objectManager = GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');

		/** @var \TYPO3\CMS\Extbase\Service\TypoScriptService $typoScriptService */
		$typoScriptService = $objectManager->get('\TYPO3\CMS\Extbase\Service\TypoScriptService');
		$settings = TyposcriptUtility::getTypoScriptSetup('tx_mecleverreach', 'settings');

		if (is_array($settings) && $typoScriptService instanceof TypoScriptService) {
			return $typoScriptService->convertTypoScriptArrayToPlainArray($settings);
		}

		return FALSE;
	}
}