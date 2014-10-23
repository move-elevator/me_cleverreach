<?php

namespace MoveElevator\MeCleverreach\Service;

use \MoveElevator\MeCleverreach\Utility\SettingsUtility;
use \MoveElevator\MeCleverreach\Utility\SoapUtility;
use \MoveElevator\MeCleverreach\Domain\Model\User;

/**
 * Class SubscribeService
 *
 * @package MoveElevator\MeCleverreach\Service
 */
class SubscribeService {
	/**
	 * @var \SoapClient
	 */
	protected $soapClient;

	/**
	 * @var array
	 */
	protected $settings = array();

	/**
	 * Initialize subscribe service
	 */
	public function initializeObject() {
		$this->settings = SettingsUtility::getSettings();
		$this->soapClient = SoapUtility::initializeApi();
	}

	/**
	 * @param \MoveElevator\MeCleverreach\Domain\Model\User $user
	 * @return array
	 */
	public function subscribe(User $user) {
		$result = array();

		$soapResponse = $this->soapClient->receiverAdd(
			$this->settings['config']['apiKey'],
			$this->settings['config']['listId'],
			$user->toArray()
		);

		$result['subscriptionState'] = $soapResponse->status;

		if (intval($this->settings['directSubscription']) !== 1) {
			$result['directSubscription'] = FALSE;
			$soapResponseSendActivationMail = $this->soapClient->formsSendActivationMail(
				$this->settings['config']['apiKey'],
				$this->settings['config']['formId'],
				$user->getEmail(),
				$this->getMailHeader($user)
			);
			//@todo validate and add message to view
		} else {
			$result['directSubscription'] = TRUE;
			$soapResponse = $this->soapClient->receiverSetActive($this->settings['config']['apiKey'], $this->settings['config']['listId'], $user->getEmail());
			//@todo validate and add message to view
		}

		return $result;
	}

	/**
	 * @param \MoveElevator\MeCleverreach\Domain\Model\User $user
	 * @param string $extraInfo
	 * @return array
	 */
	protected function getMailHeader(User $user, $extraInfo = '') {
		return array(
			"user_ip" => $GLOBALS['_ENV']['REMOTE_ADDR'],
			"user_agent" => $GLOBALS['_ENV']['HTTP_USER_AGENT'],
			"referer" => $GLOBALS['_ENV']['HTTP_REFERER'],
			"postdata" => $user->getPostData(),
			"info" => $extraInfo,
		);
	}
}