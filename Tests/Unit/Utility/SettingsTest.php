<?php

namespace MoveElevator\MeCleverreach\Tests\Unit\Utility;

use \TYPO3\CMS\Core\Tests\UnitTestCase;


class SettingsTest extends UnitTestCase {
	/**
	 * @test
	 * @return void
	 */
	public function testGetSettings() {
		$settings = \MoveElevator\MeCleverreach\Utility\SettingsUtility::getSettings();
		$this->assertNotFalse($settings);
		$this->assertTrue(is_array($settings));
	}
}
