<?php

namespace MoveElevator\MeCleverreach\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class AbstractBaseController
 *
 * @package MoveElevator\MeCleverreach\Controller
 */
abstract class AbstractBaseController extends ActionController {

	/** @var \SoapClient */
	protected $soapClient;

	/**
	 * http://support.cleverreach.de/entries/20674817-Fehlercode-API
	 */
	const API_INVALID_API_KEY = 1;
	const API_MISSING_SESSION = 5;
	const API_PERMISSION_DENIED = 10;
	const API_DATA_NOT_FOUND = 20;
	const API_EMAIL_INVALID = 30;
	const API_EMAIL_BLACK_LISTET = 40;
	const API_DUPLICATE_DATA = 50;
	const API_SUBSCRIBER_ALLREADY_ACTIVE = 60;
	const API_INSERT_ORDER_FAILED = 70;
	const API_BATCH_TO_BIG = 80;
	const API_SUBSCRIBER_ALLREADY_INACTIVE = 90;
	const API_GIVEN_MAIL_TO_SHORT = 100;
	const API_NO_FORMS_AVAILABLE = 110;
	const API_ERROR_SAVING_FILTER = 120;

	/**
	 * Initialize every action
	 *
	 * @throws \Exception
	 * @return void
	 */
	protected function initializeAction() {
		if (!class_exists('SoapClient')) {
			throw new \Exception('SoapClient not available!');
		}
		$this->soapClient = new \SoapClient($this->settings['config']['wsdlUrl']);
	}

	/**
	 * Converts Array into CleverReach supported format
	 *
	 * @param array $formData
	 * @return array
	 */
	protected function convertAttributes(array $formData) {
		$attributes = array();

		foreach ($formData as $key => $val) {
			$attributes[] = array('key' => str_replace(" ", "_", strtolower($key)), 'value' => $val);
		}

		return $attributes;
	}
}