<?php

namespace MoveElevator\MeCleverreach\Controller;

use \TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \MoveElevator\MeCleverreach\Domain\Model\User;
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
	 * @throws \Exception
	 */
	protected function initializeAction() {
		$this->soapClient = SoapUtility::initializeApi();
	}

	/**
	 * @param $argument
	 * @return mixed
	 */
	protected function getRequestArgumentIfExisting($argument) {
		if($this->request->hasArgument($argument)) {
			return $this->request->getArgument($argument);
		}

		return NULL;
	}
}