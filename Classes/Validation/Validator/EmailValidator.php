<?php

namespace MoveElevator\MeCleverreach\Validation\Validator;

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use MoveElevator\MeCleverreach\Domain\Model\User;
use MoveElevator\MeCleverreach\Utility\SoapUtility;
use TYPO3\CMS\Backend\FrontendBackendUserAuthentication;

/**
 * Class EmailValidator
 *
 * @package MoveElevator\MeCleverreach\Validation\Validator
 */
class EmailValidator extends AbstractBaseValidator
{

    const ERROR_LEVEL_INDEX = 2;

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
    public function initializeObject()
    {
        parent::initializeObject();

        $this->soapClient = SoapUtility::initializeApi();
    }

    /**
     * Validate email from user and set error message if necessary
     *
     * @param \MoveElevator\MeCleverreach\Domain\Model\User|NULL $value
     *
     * @return boolean
     */
    public function isValid($value)
    {
        $valid = false;

        if (!$value instanceof User) {
            return false;
        }

        $soapResponse = $this->soapClient->receiverGetByEmail(
            $this->settings['config']['apiKey'],
            $this->settings['config']['listId'],
            $value->getEmail(),
            0
        );

        if ($soapResponse->statuscode == SoapUtility::API_DATA_NOT_FOUND
            || intval($soapResponse->data->deactivated) > 0) {
                return true;
        }

        $message = LocalizationUtility::translate('form.already_exists.subscribe', 'me_cleverreach');
        $this->addError($message, 1400589371, array('property' => 'email'));
        $this->logErrorIfNecessary($soapResponse);

        return false;
    }

    /**
     * @param \SoapClient $soapResponse
     * @return void
     */
    protected function logErrorIfNecessary($soapResponse)
    {
        if ($soapResponse->status === 'ERROR'
            && $soapResponse->statuscode != SoapUtility::API_DATA_NOT_FOUND
        ) {
            /** @var FrontendBackendUserAuthentication $frontendBackendUserAuthentication */
            $frontendBackendUserAuthentication =
                $this->objectManager->get('TYPO3\CMS\Backend\FrontendBackendUserAuthentication');
            $frontendBackendUserAuthentication->simplelog(
                'CleverReach api error: ' . $soapResponse->message,
                'me_cleverreach',
                self::ERROR_LEVEL_INDEX
            );
        }
    }
}
