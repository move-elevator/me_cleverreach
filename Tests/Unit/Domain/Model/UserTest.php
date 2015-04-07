<?php

namespace MoveElevator\MeCleverreach\Tests\Unit\Domain\Model;

use \TYPO3\CMS\Core\Tests\UnitTestCase;

/**
 * Class UserTest
 *
 * @package MoveElevator\MeCleverreach\Tests\Unit\Domain\Model
 */
class UserTest extends UnitTestCase {

	/**
	 * @var \MoveElevator\MeCleverreach\Domain\Model\User
	 */
	protected $fixture;

	/*
	 * @var array
	 */
	protected $testConfig;

	/**
	 * @return void
	 */
	public function setUp() {
		$this->fixture = new \MoveElevator\MeCleverreach\Domain\Model\User();

		$this->testConfig = array(
			'firstName' => 'Mein Vorname',
			'lastName' => 'Mein Vorname',
			'Email' => 'test@test.de',
		);
	}

	/**
	 * @return void
	 */
	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 * @covers \MoveElevator\MeCleverreach\Domain\Model\User::setFirstName
	 * @return void
	 */
	public function testSetFirstNameStringAndGetsSame() {
		$this->fixture->setFirstName($this->testConfig['firstName']);
		$this->assertSame($this->fixture->getFirstName(), $this->testConfig['firstName']);
	}

	/**
	 * @test
	 * @covers \MoveElevator\MeCleverreach\Domain\Model\User::setLastName
	 * @return void
	 */
	public function testSetLastNameStringAndGetsSame() {
		$this->fixture->setLastName($this->testConfig['lastName']);
		$this->assertSame($this->fixture->getLastName(), $this->testConfig['lastName']);
	}

	/**
	 * @test
	 * @covers \MoveElevator\MeCleverreach\Domain\Model\User::setEmail
	 * @return void
	 */
	public function testSetEmailStringAndGetsSame() {
		$this->fixture->setEmail($this->testConfig['Email']);
		$this->assertSame($this->fixture->getEmail(), $this->testConfig['Email']);
	}

	/**
	 * @test
	 * @covers \MoveElevator\MeCleverreach\Domain\Model\User::toArray
	 * @return void
	 */
	public function testToArray() {
		$this->fixture->setEmail($this->testConfig['Email']);
		$result = $this->fixture->toArray();

		foreach ($result['attributes'] as $attribute) {
			if ('email' === $attribute['key']) {
				$this->assertSame($this->fixture->getEmail(), $attribute['value']);
			}
		}
	}

	/**
	 * @test
	 * @covers \MoveElevator\MeCleverreach\Domain\Model\User::getPostData
	 * @return void
	 */
	public function testPostData() {
		$this->fixture->setEmail($this->testConfig['Email']);

		$this->assertNotFalse(strstr($this->fixture->getPostData(), 'email:' . $this->testConfig['Email']));
	}
}
