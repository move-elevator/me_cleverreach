<?php

namespace MoveElevator\MeCleverreach\Controller;

use \MoveElevator\MeCleverreach\Controller\AbstractBaseController;
use \MoveElevator\MeCleverreach\Domain\Model\User;
use \MoveElevator\MeCleverreach\Utility\SoapUtility;

/**
 * Class SubscribeController
 *
 * @package MoveElevator\MeCleverreach\Controller
 */
class SubscribeController extends AbstractBaseController {

	/**
	 * @var \MoveElevator\MeCleverreach\Service\SubscribeService
	 * @inject
	 */
	protected $subscribeService;

	/**
	 * Show the SubscribeForm
	 *
	 * @return void
	 */
	public function subscribeFormAction() {
		if (
			$this->getRequestArgumentIfExisting('user') instanceof User
			&& $this->getRequestArgumentIfExisting('subscriptionState') !== NULL
		) {
			$this->view->assignMultiple(array(
				'user' => $this->request->getArgument('user'),
				'subscriptionState' => $this->getRequestArgumentIfExisting('subscriptionState')
			));
			$this->request->setArgument('subscriptionState', NULL);
			$this->request->setArgument('user', NULL);
		}
	}

	/**
	 * @return void
	 */
	public function initializeSubscribeAction() {
		if ($this->getRequestArgumentIfExisting('user') === NULL) {
			$this->redirect('subscribeForm');
		}
	}

	/**
	 * Subscribe the user to CleverReach
	 *
	 * @param \MoveElevator\MeCleverreach\Domain\Model\User $user
	 * @validate $user MoveElevator.MeCleverreach:Email
	 * @return void
	 */
	public function subscribeAction(User $user) {
		$result = $this->subscribeService->subscribe($user);
		if ($result['subscriptionState'] == 'ERROR') {
			$this->forward(
				'subscribeForm',
				NULL,
				NULL,
				array(
					'subscriptionState' => 'ERROR',
					'user' => $user
				)
			);
		}

		$this->view->assignMultiple(array(
			'user' => $user,
			'subscriptionState' => $result['subscriptionState'],
			'directSubscription' => $result['directSubscription']
		));
	}
}