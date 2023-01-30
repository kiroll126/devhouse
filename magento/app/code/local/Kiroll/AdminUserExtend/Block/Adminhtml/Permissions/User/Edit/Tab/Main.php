<?php

/**
 * @category   Kiroll
 * @package    Kiroll_AdminUserExtend
 * @author     Kirill Olefirenko <kiroll161@gmail.com>
 */

class Kiroll_AdminUserExtend_Block_Adminhtml_Permissions_User_Edit_Tab_Main extends Mage_Adminhtml_Block_Permissions_User_Edit_Tab_Main
{
    /**
     * @return $this
     *
     * Add new fields to permission form
     */
    protected function _prepareForm()
    {
        parent::_prepareForm();

        $model = Mage::registry('permissions_user');
        $model->unsetData('password');

        $form = $this->getForm();
        $form->addData(['enctype' => 'multipart/form-data']);

        $fieldset = $form->getElement('base_fieldset');
        Mage::helper('admin_user_extend/form')->addNewFieldsToFieldset($fieldset, $model);

        $form->setValues($model->getData());

        return $this;
    }
}