<?php

namespace MoveElevator\MeCleverreach\Controller;

use \TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use \MoveElevator\MeCleverreach\Utility\SoapUtility;

/**
 * Class AbstractBaseController
 *
 * @package MoveElevator\MeCleverreach\Controller
 */
abstract class AbstractBaseController extends ActionController {

	/** @var \SoapClient */
	protected $soapClient;

	/**
	 * Initialize all controller actions
	 *
	 * @return void
	 * @throws \Exception
	 */
	protected function initializeAction() {
		$this->soapClient = SoapUtility::initializeApi();
	}

	/**
	 * Get request argument is existing
	 *
	 * @param mixed $argument
	 * @return mixed
	 */
	protected function getRequestArgumentIfExisting($argument) {
		if ($this->request->hasArgument($argument)) {
			return $this->request->getArgument($argument);
		}

		return NULL;
	}
}