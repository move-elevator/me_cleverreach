<?php

namespace MoveElevator\MeCleverreach\Validation\Validator;

use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;
use TYPO3\CMS\Extbase\Validation\Validator\ValidatorInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use MoveElevator\MeCleverreach\Utility\SettingsUtility;

/**
 * Class AbstractBaseValidator
 *
 * @package MoveElevator\MeCleverreach\Validation\Validator
 */
abstract class AbstractBaseValidator extends AbstractValidator implements ValidatorInterface
{
    /**
     * @var array
     */
    protected $settings = array();

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;

    /**
     * Initialize validation and get TypoScript settings
     *
     * @return void
     */
    public function initializeObject()
    {
        $this->settings = SettingsUtility::getSettings();
        $this->objectManager = GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
    }
}
