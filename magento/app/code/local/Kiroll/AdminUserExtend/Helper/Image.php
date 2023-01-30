<?php

class Kiroll_AdminUserExtend_Helper_Image extends Mage_Core_Helper_Abstract
{
    /**
     * @return false|string
     * @throws Exception
     *
     * Upload new image
     */
    public function uploadImage($key)
    {
        if (!isset($_FILES[$key]['name']) || $_FILES[$key]['name'] == '') {
            return false;
        }

        $path = $this->getProfilePhotoPath();

        try {
            $uploader = new Mage_Core_Model_File_Uploader($key);
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
            Mage::getSingleton('adminhtml/session')->addError($this->__("Image not loaded. %s", $e->getMessage()));
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param $photo
     * @return bool
     * @throws Exception
     *
     * Removed old profile photo
     */
    public function removeImage($image)
    {
        $path = $this->getProfilePhotoPath();

        try {
            $io = new Varien_Io_File();
            $io->rm($path . DS . $image);
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($this->__("Image not removed. %s", $e->getMessage()));
            throw new Exception($e->getMessage());
        }

        return true;
    }

    public function getProfilePhotoPath()
    {
        return Mage::getBaseDir('media') . DS . 'admin' . DS . 'photo';
    }

    public function getProfilePhotoUrl()
    {
        return Mage::getBaseUrl('media') . DS . 'admin' . DS . 'photo';
    }

    public function getDefaultProfilePhoto()
    {
        return Mage::getDesign()->getSkinBaseUrl(array('_area'=>'adminhtml', '_theme'=>'default')) . 'images' . DS . 'header' . DS . 'default-photo.jpeg';
    }
}