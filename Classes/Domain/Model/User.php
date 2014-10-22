<?php

namespace MoveElevator\MeCleverreach\Domain\Model;

use \TYPO3\CMS\Extbase\DomainObject\AbstractValueObject;

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
	 * @param string $firstName
	 */
	public function setFirstName($firstName) {
		$this->firstName = $firstName;
	}

	/**
	 * @return string
	 */
	public function getFirstName() {
		return $this->firstName;
	}

	/**
	 * @param string $lastName
	 */
	public function setLastName($lastName) {
		$this->lastName = $lastName;
	}

	/**
	 * @return string
	 */
	public function getLastName() {
		return $this->lastName;
	}

	/**
	 * @param string $email
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @return array
	 */
	public function toArray() {
		$properties = get_object_vars($this);
		$properties['arguments'] = $this->_getConvertAttributes();

		return $properties;
	}

	/**
	 * Converts Array into CleverReach supported format
	 *
	 * @return array
	 */
	protected function _getConvertAttributes() {
		$attributes = array();

		foreach (get_object_vars($this) as $key => $value) {
			$attributes[] = array('key' => str_replace(" ", "_", strtolower($key)), 'value' => $value);
		}

		return $attributes;
	}

	/**
	 * @return string
	 */
	public function getPostData() {
		$postData = '';
		$attributes = $this->_getConvertAttributes();

		for($index = 0; $index < count($attributes); $index++) {
			if ($index > 0) {
				$postData .= ',';
			}
			$postData .= $attributes[$index]['key'] . ':' . $attributes[$index]['value'];
		}

		return $postData;
	}
}