<?php

namespace MoveElevator\MeCleverreach\Controller;

use \MoveElevator\MeCleverreach\Controller\AbstractBaseController;
use \MoveElevator\MeCleverreach\Domain\Model\User;

/**
 * Class SubscribeController
 *
 * @package MoveElevator\MeCleverreach\Controller
 */
class SubscribeController extends AbstractBaseController {

	/**
	 * Show the SubscribeForm
	 *
	 * @return void
	 */
	public function subscribeFormAction() {
		if ($this->request->hasArgument('user') && $this->request->getArgument('user') instanceof User) {
			$this->view->assignMultiple(array(
				'user' => $this->request->getArgument('user'),
				'subscriptionState' => $this->getRequestArgumentIfExisting('subscriptionState')
			));
		}
	}

	/**
	 * Subscribe the user to CleverReach
	 *
	 * @param \MoveElevator\MeCleverreach\Domain\Model\User $user
	 * @return void
	 * @todo outsourced logic in service
	 */
	public function subscribeAction(User $user) {
		$soapResponse = $this->soapClient->receiverGetByEmail($this->settings['config']['apiKey'], $this->settings['config']['listId'], $user->getEmail(), 0);

		if ($soapResponse->statuscode == self::API_DATA_NOT_FOUND) {
			$soapResponse = $this->soapClient->receiverAdd($this->settings['config']['apiKey'], $this->settings['config']['listId'], $user->toArray());
			$subscriptionState = 'success';
		} else {
			$this->forward('subscribeForm', NULL, NULL, array(
				'user' => $user,
				'subscriptionState' => 'already_exists'
			));
		}

		if (intval($this->settings['directSubscription']) !== 1) {
			$directSubscription = FALSE;
			$soapResponseSetInactive = $this->soapClient->receiverSetInactive($this->settings['config']['apiKey'], $this->settings['config']['listId'], $user->getEmail());
			$soapResponseSendActivationMail = $this->soapClient->formsSendActivationMail(
				$this->settings['config']['apiKey'],
				$this->settings['config']['formId'],
				$user->getEmail(),
				$this->getMailHeader($user)
			);
			//@todo validate and add message to view
		} else {
			$directSubscription = TRUE;
			$soapResponse = $this->soapClient->receiverSetActive($this->settings['config']['apiKey'], $this->settings['config']['listId'], $user->getEmail());
			//@todo validate and add message to view
		}

		$this->view->assignMultiple(array(
			'user' => $user,
			'subscriptionState' => $subscriptionState,
			'directSubscription' => $directSubscription
		));
	}
}