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
        $fieldset = $form->getElement('base_fieldset');

        $fieldset->addField('job_description', 'text', [
            'name'      => 'job_description',
            'label'     => Mage::helper('admin_user_extend')->__('Job Description'),
            'title'     => Mage::helper('admin_user_extend')->__('Job Description'),
            ]);

        $fieldset->addField('phone', 'text', [
            'name'      => 'phone',
            'label'     => Mage::helper('admin_user_extend')->__('Phone Number'),
            'title'     => Mage::helper('admin_user_extend')->__('Phone Number'),
            ]);

        $fieldset->addField('photo', 'file', [
            'name'      => 'photo',
            'label'     => Mage::helper('admin_user_extend')->__('Profile Photo'),
            'title'     => Mage::helper('admin_user_extend')->__('Profile Photo'),
            ]);

        $form->setValues($user->getData());

        return $this;
    }
}