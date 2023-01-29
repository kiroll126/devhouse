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
            'after_element_html' => $this->getImageHtml($user->getPhoto()),
        ]);

        return $this;
    }

    protected function getImageHtml($img)
    {
        $html = '';
        if ($img) {
            $html .= '<p style="margin-top: 5px">';
            $html .= '<img src="'.Mage::getBaseUrl('media') . DS . 'admin' . DS . 'photo' . DS . $img .'" width="100"/>';
            $html .= '</p>';
        }
        return $html;
    }
}