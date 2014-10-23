<?php

namespace MoveElevator\MeCleverreach\Validation\Validator;

use \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;
use \TYPO3\CMS\Extbase\Validation\Validator\ValidatorInterface;
use \MoveElevator\MeCleverreach\Utility\SettingsUtility;

/**
 * Class AbstractBaseValidator
 *
 * @package MoveElevator\MeCleverreach\Validation\Validator
 */
abstract class AbstractBaseValidator extends AbstractValidator implements ValidatorInterface {
	/**
	 * @var array
	 */
	protected $settings = array();

	/**
	 * Initialize validation and get TypoScript settings
	 *
	 * @return void
	 */
	public function initializeObject() {
		$this->settings = SettingsUtility::getSettings();
	}
}