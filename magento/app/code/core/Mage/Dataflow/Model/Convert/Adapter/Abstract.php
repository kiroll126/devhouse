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
 * @package    Mage_Dataflow
 * @copyright  Copyright (c) 2006-2020 Magento, Inc. (https://www.magento.com)
 * @copyright  Copyright (c) 2022 The OpenMage Contributors (https://www.openmage.org)
 * @license    https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Convert abstract adapter
 *
 * @category   Mage
 * @package    Mage_Dataflow
 * @author     Magento Core Team <core@magentocommerce.com>
 */
abstract class Mage_Dataflow_Model_Convert_Adapter_Abstract extends Mage_Dataflow_Model_Convert_Container_Abstract implements Mage_Dataflow_Model_Convert_Adapter_Interface
{
    /**
     * Adapter resource instance
     *
     * @var object
     */
    protected $_resource;

    /**
     * Retrieve resource generic method
     *
     * @return object
     */
    public function getResource()
    {
        return $this->_resource;
    }

    /**
     * Set resource for the adapter
     *
     * @param object $resource
     * @return Mage_Dataflow_Model_Convert_Adapter_Abstract
     */
    public function setResource($resource)
    {
        $this->_resource = $resource;
        return $this;
    }

    public function getNumber($value)
    {
        if (!($separator = $this->getBatchParams('decimal_separator'))) {
            $separator = '.';
        }

        $allow  = ['0',1,2,3,4,5,6,7,8,9,'-',$separator];

        $number = '';
        for ($i = 0; $i < strlen($value); $i++) {
            if (in_array($value[$i], $allow)) {
                $number .= $value[$i];
            }
        }

        if ($separator != '.') {
            $number = str_replace($separator, '.', $number);
        }

        return (float) $number;
    }
}