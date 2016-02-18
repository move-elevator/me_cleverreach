<?php

namespace MoveElevator\MeCleverreach\Controller;

use MoveElevator\MeCleverreach\Domain\Model\User;

/**
 * Class SubscribeController
 *
 * @package MoveElevator\MeCleverreach\Controller
 */
class SubscribeController extends AbstractBaseController
{

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
    public function subscribeFormAction()
    {
        if (
            $this->getRequestArgumentIfExisting('user') instanceof User
            && $this->getRequestArgumentIfExisting('subscriptionState') !== null
        ) {
            $this->view->assignMultiple(
                array(
                    'user' => $this->request->getArgument('user'),
                    'subscriptionState' => $this->getRequestArgumentIfExisting('subscriptionState')
                )
            );
            $this->request->setArgument('subscriptionState', null);
            $this->request->setArgument('user', null);
        }
    }

    /**
     * Initialize subscribe action, redirect to subscribeFormAction
     * if user in request equal null
     *
     * @return void
     */
    public function initializeSubscribeAction()
    {
        if ($this->getRequestArgumentIfExisting('user') === null) {
            $this->redirect('subscribeForm');
        }
    }

    /**
     * Subscribe a user to CleverReach
     *
     * @param \MoveElevator\MeCleverreach\Domain\Model\User $user
     * @validate $user MoveElevator.MeCleverreach:Email
     *
     * @return void
     */
    public function subscribeAction(User $user)
    {
        $result = $this->subscribeService->subscribe($user);

        if ($result['subscriptionState'] == 'ERROR') {
            $this->forward(
                'subscribeForm',
                null,
                null,
                array(
                    'subscriptionState' => 'ERROR',
                    'user' => $user
                )
            );
        }

        $this->view->assignMultiple(
            array(
                'user' => $user,
                'subscriptionState' => $result['subscriptionState'],
                'directSubscription' => $result['directSubscription']
            )
        );
    }
}
