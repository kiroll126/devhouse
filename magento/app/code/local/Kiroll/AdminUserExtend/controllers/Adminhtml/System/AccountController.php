<?php

require_once Mage::getModuleDir('controllers', 'Mage_Adminhtml') . DS . 'System' . DS . 'AccountController.php';

class Kiroll_AdminUserExtend_Adminhtml_System_AccountController extends Mage_Adminhtml_System_AccountController
{
    /**
     * Saving edited user information
     */
    public function saveAction()
    {
        $userId = Mage::getSingleton('admin/session')->getUser()->getId();
        $pwd    = null;

        $user = Mage::getModel("admin/user")->load($userId);

        $user->setId($userId)
            ->setUsername($this->getRequest()->getParam('username', false))
            ->setFirstname($this->getRequest()->getParam('firstname', false))
            ->setLastname($this->getRequest()->getParam('lastname', false))
            ->setEmail(strtolower($this->getRequest()->getParam('email', false)))
            ->setJobDescription($this->getRequest()->getParam('job_description', false))
            ->setPhone($this->getRequest()->getParam('phone', false));

        if ($this->getRequest()->getParam('new_password', false)) {
            $user->setNewPassword($this->getRequest()->getParam('new_password', false));
        }

        if ($this->getRequest()->getParam('password_confirmation', false)) {
            $user->setPasswordConfirmation($this->getRequest()->getParam('password_confirmation', false));
        }

        //Validate current admin password
        $currentPassword = $this->getRequest()->getParam('current_password', null);
        $this->getRequest()->setParam('current_password', null);
        $result = $this->_validateCurrentPassword($currentPassword);

        if (!is_array($result)) {
            $result = $user->validate();
        }
        if (is_array($result)) {
            foreach ($result as $error) {
                Mage::getSingleton('adminhtml/session')->addError($error);
            }
            $this->getResponse()->setRedirect($this->getUrl("*/*/"));
            return;
        }

        try {
            $photoPath = $this->uploadImage();
            if ($photoPath) $user->setPhoto($photoPath);

            $user->save();
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('The account has been saved.'));
        } catch (Mage_Core_Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('An error occurred while saving account.'));
        }
        $this->getResponse()->setRedirect($this->getUrl("*/*/"));
    }

    protected function uploadImage()
    {
        if (!isset($_FILES['photo']['name']) || $_FILES['photo']['name'] == '') {
            return false;
        }

        $path = Mage::getBaseDir('media') . DS . 'admin' . DS . 'photo';

        try {
            $uploader = new Mage_Core_Model_File_Uploader('photo');
            $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
            $uploader->setAllowRenameFiles(true);
            $uploader->addValidateCallback(
                Mage_Core_Model_File_Validator_Image::NAME,
                new Mage_Core_Model_File_Validator_Image(),
                "validate"
            );
            $result = $uploader->save($path);
            return $result['file'];
        } catch (Exception $e) {
            $this->_getSession()->addError(Mage::helper('adminhtml')->__("Image not loaded. %s", $e->getMessage()));
            throw new Exception($e->getMessage());
        }
    }
}