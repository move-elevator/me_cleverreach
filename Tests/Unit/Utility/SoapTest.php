<?php

namespace MoveElevator\MeCleverreach\Tests\Unit\Utility;

use \TYPO3\CMS\Core\Tests\UnitTestCase;


class SoapTest extends UnitTestCase {
	/**
	 * @test
	 * @return void
	 */
	public function testGetSoapClient() {
		/** @var \SoapClient $soapClient */
		$soapClient = \MoveElevator\MeCleverreach\Utility\SoapUtility::initializeApi();
		$this->assertTrue($soapClient instanceof \SoapClient);
	}
}
