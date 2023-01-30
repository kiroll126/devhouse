<?php

/**
 * @category   Kiroll
 * @package    Kiroll_AdminUserExtend
 * @author     Kirill Olefirenko <kiroll161@gmail.com>
 */

class Kiroll_AdminUserExtend_Helper_Form extends Mage_Core_Helper_Abstract
{
    public function addNewFieldsToFieldset($fieldset, $model)
    {
        $fieldset->addField('job_description', 'textarea', [
            'name'      => 'job_description',
            'label'     => $this->__('Job Description'),
            'title'     => $this->__('Job Description'),
        ]);

        $fieldset->addField('phone', 'text', [
            'name'      => 'phone',
            'label'     => $this->__('Phone Number'),
            'title'     => $this->__('Phone Number'),
        ]);

        $fieldset->addField('photo', 'file', [
            'name'      => 'photo',
            'label'     => $this->__('Profile Photo'),
            'title'     => $this->__('Profile Photo'),
            'after_element_html' => $this->getImageHtml($model->getPhoto()),
        ]);

        if ($model->getPhoto()) {
            $fieldset->addField('remove_photo', 'select', [
                'name'   => 'remove_photo',
                'label'  => $this->__('Remove Profile Photo'),
                'title'  => $this->__('Remove Profile Photo'),
                'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
            ]);
        }

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