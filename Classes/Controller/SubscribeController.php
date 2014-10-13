<?php

namespace MoveElevator\MeCleverreach\Controller;

/**
 * Class AbstractBaseController
 *
 * @package MoveElevator\MeCleverreach\Controller
 */
class SubscribeController extends AbstractBaseController {

	/**
	 * Initialize every action
	 *
	 * @throws \Exception
	 * @return void
	 */
	public function initializeAction() {

	}

	/**
	 * Show the SubscribeForm
	 *
	 * @return void
	 */
	public function subscribeFormAction() {
		//just render the template
	}

	/**
	 * Subscribe the user to CleverReach
	 *
	 * @todo replace hard-coded form-id (88377) and list-id (153074) by settings
	 * @return void
	 */
	public function subscribeAction() {

		$userData = array();

		$userData['source'] = $this->settings['source'];
		$userData['registered'] = time();

		$userData['email'] = $this->request->getArgument('email');
		$userData['attributes'] = $this->request->getArgument('email');

		$userData['attributes'] = $this->convertAttributes($this->request->getArguments());
		$soapResponse = $this->soapClient->receiverGetByEmail($this->settings['config']['apiKey'], 153074, $userData['email'], 0);

		if ($soapResponse->statuscode == self::API_DATA_NOT_FOUND) {
			$soapResponse = $this->soapClient->receiverAdd($this->settings['config']['apiKey'], 153074, $userData);
			//@todo add success message to view
		} else {
			//@todo add user is already exists to view
		}
		if (intval($this->settings['directSubscription']) === 1) {
			$soapResponse = $this->soapClient->receiverSetActive($this->settings['config']['apiKey'], 153074, $userData['email']);
			//@todo validate and add message to view
		} else {
			$soapResponse = $this->soapClient->formsActivationMail($this->settings['config']['apiKey'], 88377, $userData['email']);
			//@todo validate and add message to view
		}
	}
}