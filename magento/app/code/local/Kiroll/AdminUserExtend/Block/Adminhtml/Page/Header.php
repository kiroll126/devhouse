<?php

class Kiroll_AdminUserExtend_Block_Adminhtml_Page_Header extends Mage_Adminhtml_Block_Page_Header
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('kiroll/header.phtml');
    }

    public function getAdminPhoto()
    {
        $imageHelper = Mage::helper('admin_user_extend/image');

        if ($photo = $this->getUser()->getPhoto()) {
            return $imageHelper->getProfilePhotoUrl() . DS . $photo;
        }

        return $imageHelper->getDefaultProfilePhoto();
    }
}