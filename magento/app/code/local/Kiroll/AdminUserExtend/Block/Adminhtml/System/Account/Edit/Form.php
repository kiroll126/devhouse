<?php

class Kiroll_AdminUserExtend_Block_Adminhtml_System_Account_Edit_Form extends Mage_Adminhtml_Block_System_Account_Edit_Form
{
    protected function _prepareForm()
    {
        parent::_prepareForm();

        $userId = Mage::getSingleton('admin/session')->getUser()->getId();
        $user = Mage::getModel('admin/user')
            ->load($userId);
        $user->unsetData('password');

        $form = $this->getForm();
        $form->addData(['enctype' => 'multipart/form-data']);

        $fieldset = $form->getElement('base_fieldset');
        Mage::helper('admin_user_extend/form')->addNewFieldsToFieldset($fieldset, $user);

        $form->setValues($user->getData());

        return $this;
    }
}