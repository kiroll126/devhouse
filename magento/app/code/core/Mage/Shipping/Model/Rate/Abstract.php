<?php
/**
 * OpenMage
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * @category   Mage
 * @package    Mage_Shipping
 * @copyright  Copyright (c) 2006-2020 Magento, Inc. (https://www.magento.com)
 * @copyright  Copyright (c) 2020-2022 The OpenMage Contributors (https://www.openmage.org)
 * @license    https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Class Mage_Shipping_Model_Rate_Abstract
 *
 * @category   Mage
 * @package    Mage_Shipping
 * @author     Magento Core Team <core@magentocommerce.com>
 *
 * @method string getCarrier()
 */
abstract class Mage_Shipping_Model_Rate_Abstract extends Mage_Core_Model_Abstract
{
    protected static $_instances;

    /**
     * @return Mage_Shipping_Model_Carrier_Abstract
     */
    public function getCarrierInstance()
    {
        $code = $this->getCarrier();
        if (!isset(self::$_instances[$code])) {
            self::$_instances[$code] = Mage::getModel('shipping/config')->getCarrierInstance($code);
        }
        return self::$_instances[$code];
    }
}
