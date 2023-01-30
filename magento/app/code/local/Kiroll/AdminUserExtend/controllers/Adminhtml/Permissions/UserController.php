<?php

require_once Mage::getModuleDir('controllers', 'Mage_Adminhtml') . DS . 'Permissions' . DS . 'UserController.php';

class Kiroll_AdminUserExtend_Adminhtml_Permissions_UserController extends Mage_Adminhtml_Permissions_UserController
{
    /**
     * Add profile photo uploading to controller
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $id = $this->getRequest()->getParam('user_id');
            $model = Mage::getModel('admin/user')->load($id);
            // @var $isNew flag for detecting new admin user creation.
            $isNew = !$model->getId() ? true : false;
            if (!$model->getId() && $id) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('This user no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }

            $imageHelper = Mage::helper('admin_user_extend/image');
            $oldPhoto = $model->getPhoto();

            //Validate current admin password
            $currentPassword = $this->getRequest()->getParam('current_password', null);
            $this->getRequest()->setParam('current_password', null);
            unset($data['current_password']);
            $result = $this->_validateCurrentPassword($currentPassword);

            $model->setData($data);

            /*
             * Unsetting new password and password confirmation if they are blank
             */
            if ($model->hasNewPassword() && $model->getNewPassword() === '') {
                $model->unsNewPassword();
            }
            if ($model->hasPasswordConfirmation() && $model->getPasswordConfirmation() === '') {
                $model->unsPasswordConfirmation();
            }

            if (!is_array($result)) {
                $result = $model->validate();
            }
            if (is_array($result)) {
                Mage::getSingleton('adminhtml/session')->setUserData($data);
                foreach ($result as $message) {
                    Mage::getSingleton('adminhtml/session')->addError($message);
                }
                $this->_redirect('*/*/edit', ['_current' => true]);
                return $this;
            }

            try {
                //Remove or upload profile photo
                if ($this->getRequest()->getParam('remove_photo', false)) {
                    if ($imageHelper->removeImage($oldPhoto)) $model->setPhoto(null);
                } else {
                    if ($oldPhoto) $model->setPhoto($oldPhoto);
                    $photoPath = $imageHelper->uploadImage('photo');
                    if ($photoPath) $model->setPhoto($photoPath);
                }

                $model->save();
                // Send notification to General and additional contacts (if declared) that a new admin user was created.
                if (Mage::getStoreConfigFlag('admin/security/crate_admin_user_notification') && $isNew) {
                    Mage::getModel('admin/user')->sendAdminNotification($model);
                }
                if ($uRoles = $this->getRequest()->getParam('roles', false)) {
                    if (is_array($uRoles) && (count($uRoles) >= 1)) {
                        // with fix for previous multi-roles logic
                        $model->setRoleIds(array_slice($uRoles, 0, 1))
                            ->setRoleUserId($model->getUserId())
                            ->saveRelations();
                    }
                }
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The user has been saved.'));
                Mage::getSingleton('adminhtml/session')->setUserData(false);
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setUserData($data);
                $this->_redirect('*/*/edit', ['user_id' => $model->getUserId()]);
                return;
            }
        }
        $this->_redirect('*/*/');
    }
}