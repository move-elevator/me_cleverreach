<?php

namespace MoveElevator\MeCleverreach\Domain\Model;

use \TYPO3\CMS\Extbase\DomainObject\AbstractValueObject;
use \MoveElevator\MeCleverreach\Utility\SettingsUtility;

/**
 * Class FirstCharFilter
 *
 * @package MoveElevator\MeAddress\Domain\Model\FormObject
 */
class User extends AbstractValueObject {
	/**
	 * @var string
	 * @validate NotEmpty
	 */
	protected $firstName;

	/**
	 * @var string
	 * @validate NotEmpty
	 */
	protected $lastName;

	/**
	 * @var string
	 * @validate NotEmpty
	 * @validate EmailAddress
	 */
	protected $email;

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * Initialize user model
	 *
	 * @return void
	 */
	public function initializeObject() {
		$this->settings = SettingsUtility::getSettings();
	}

	/**
	 * Set property firstName
	 *
	 * @param string $firstName
	 * @return void
	 */
	public function setFirstName($firstName) {
		$this->firstName = $firstName;
	}

	/**
	 * Get property firstName
	 *
	 * @return string
	 */
	public function getFirstName() {
		return $this->firstName;
	}

	/**
	 * Set property lastName
	 *
	 * @param string $lastName
	 * @return void
	 */
	public function setLastName($lastName) {
		$this->lastName = $lastName;
	}

	/**
	 * Get property lastName
	 *
	 * @return string
	 */
	public function getLastName() {
		return $this->lastName;
	}

	/**
	 * Get property email
	 *
	 * @param string $email
	 * @return void
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * Set property email
	 *
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Get object properties as array in from CleverReach supported format
	 *
	 * @return array
	 */
	public function toArray() {
		$properties = array(
			'email' => $this->getEmail(),
			'registered' => time(),
			'deactivated' => 0,
			'activated' => 0,
			'source' => $this->settings['config']['source'],
			'attributes' => $this->getConvertAttributes()
		);

		return $properties;
	}

	/**
	 * Converts array into CleverReach supported format
	 *
	 * @return array
	 */
	protected function getConvertAttributes() {
		$attributes = array();

		foreach (get_object_vars($this) as $key => $value) {
			$attributes[] = array('key' => str_replace(" ", "_", strtolower($key)), 'value' => $value);
		}

		return $attributes;
	}

	/**
	 * Get post data in CleverReach supported format
	 *
	 * @return string
	 */
	public function getPostData() {
		$postData = '';
		$attributes = $this->getConvertAttributes();

		for ($index = 0; $index < count($attributes); $index++) {
			if ($index > 0) {
				$postData .= ',';
			}
			$postData .= $attributes[$index]['key'] . ':' . $attributes[$index]['value'];
		}

		return $postData;
	}
}