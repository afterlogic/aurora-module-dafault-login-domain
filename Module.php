<?php
/**
 * This code is licensed under AGPLv3 license or Afterlogic Software License
 * if commercial version of the product was purchased.
 * For full statements of the licenses see LICENSE-AFTERLOGIC and LICENSE-AGPL3 files.
 */

namespace Aurora\Modules\DefaultLoginDomain;

use Aurora\System\Exceptions\ApiException;
use MailSo\Base\Validator;

/**
 * 
 * @license https://www.gnu.org/licenses/agpl-3.0.html AGPL-3.0
 * @license https://afterlogic.com/products/common-licensing Afterlogic Software License
 * @copyright Copyright (c) 2019, Afterlogic Corp.
 *
 * @package Modules
 */
class Module extends \Aurora\System\Module\AbstractWebclientModule
{
	public function init()
	{
		$this->subscribeEvent('Core::Login::before', [$this, 'onBeforeLogin']);
	}

	public function onBeforeLogin(&$aArgs)
	{
		if (isset($aArgs['Login'])) {
			$sLogin = $aArgs['Login'];
			if (!Validator::EmailString($sLogin)) {
				$sDomainName = $this->getConfig('DomainName');
				if (!empty($sDomainName)) {
					$aArgs['Login'] = $sLogin . '@' . $sDomainName;
				}
			}
		}
	}
}
