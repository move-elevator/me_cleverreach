<?php

namespace MoveElevator\MeCleverreach\Validation\Validator;

use \TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use \MoveElevator\MeCleverreach\Domain\Model\User;
use \MoveElevator\MeCleverreach\Utility\SoapUtility;


/**
 * Class EmailValidator
 *
 * @package MoveElevator\MeCleverreach\Validation\Validator
 */
class EmailValidator extends AbstractBaseValidator {
	/**
	 * @var \SoapClient
	 */
	protected $soapClient;

	/**
	 * @var
	 */
	protected $value;

	/**
	 * Initialize email validation and soap client
	 *
	 * @return void
	 */
	public function initializeObject() {
		parent::initializeObject();

		$this->soapClient = SoapUtility::initializeApi();
	}

	/**
	 * Validate email from user and set error message if necessary
	 *
	 * @param \MoveElevator\MeCleverreach\Domain\Model\User|NULL $value
	 * @return boolean
	 */
	public function isValid($value) {
		$valid = FALSE;

		if ($value instanceof User) {
			$soapResponse = $this->soapClient->receiverGetByEmail($this->settings['config']['apiKey'], $this->settings['config']['listId'], $value->getEmail(), 0);

			if ($soapResponse->statuscode == SoapUtility::API_DATA_NOT_FOUND || $soapResponse->data->active === FALSE) {
				$valid = TRUE;
			} else {
				$message = LocalizationUtility::translate('form.already_exists.subscribe', 'me_cleverreach');
				$this->addError($message, 1400589371, array('property' => 'email'));
			}
		}

		return $valid;
	}

}