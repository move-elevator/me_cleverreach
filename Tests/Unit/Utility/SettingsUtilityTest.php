<?php

namespace MoveElevator\MeCleverreach\Tests\Unit\Utility;

use \TYPO3\CMS\Core\Tests\UnitTestCase;
use \MoveElevator\MeCleverreach\Utility;

/**
 * Class SettingsUtilityTest
 *
 * @package MoveElevator\MeCleverreach\Tests\Unit\Utility
 */
class SettingsUtilityTest extends UnitTestCase {
	/**
	 * @test
	 * @cover MoveElevator\MeCleverreach\Utility\SettingsUtility::getSettings
	 * @return void
	 */
	public function testGetSettings() {
		$settings = Utility\SettingsUtility::getSettings();
		$this->assertNotFalse($settings);
		$this->assertTrue(is_array($settings));
	}
}
