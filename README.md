# TYPO3 Extension "me_cleverreach"

Implements the CleverReach API for TYPO3.

## Installation

Install and configure extension about extension manager.

## Configuration

Also it is possible to configure extension by TypoScript.

* plugin.tx_mecleverreach.settings.config.wsdlUrl = URL to api
* plugin.tx_mecleverreach.settings.config.apiKey = api key
* plugin.tx_mecleverreach.settings.config.source = list name
* plugin.tx_mecleverreach.settings.config.formId = form id
* plugin.tx_mecleverreach.settings.config.listId = list id

## How to use

Configure CleverReach api data and add plugin as page content.

## Contact

* typo3@move-elevator.de
* Company: http://www.move-elevator.de
* Issue-Tracker - https://github.com/move-elevator/me_cleverreach

## Change Log

2016-02-15  Philipp Heckelt  <phe@move-elevator.de>

    * Release for TYPO3 7
    * Changes for phpunit

2015-05-08  Steve Schütze <sts@move-elevator.de>

	* resolve dependencies to other extensions

2015-05-08  Jan Maennig  <jma@move-elevator.de>

	* Update composer.json to fixed problems at extension activation

2015-04-10  Jan Maennig  <jma@move-elevator.de>

	* Add log for api call error and add extension configuration at extension manager.

2015-04-08  Jan Maennig  <jma@move-elevator.de>

	* Initial release to TER!