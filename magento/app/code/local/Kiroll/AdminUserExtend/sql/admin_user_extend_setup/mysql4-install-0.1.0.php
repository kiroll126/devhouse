<?php

$installer = $this;
$installer->startSetup();

// Add job description for admin user
$installer->getConnection()->addColumn($installer->getTable('admin/user'), 'job_description', [
    'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
    'length' => 256,
    'nullable' => true,
    'default' => null,
    'comment' => 'Admin user job description'
]);

// Add phone number for admin user
$installer->getConnection()->addColumn($installer->getTable('admin/user'), 'phone', [
    'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
    'length' => 256,
    'nullable' => true,
    'default' => null,
    'comment' => 'Admin user phone number'
]);

// Add profile photo link for admin user
$installer->getConnection()->addColumn($installer->getTable('admin/user'), 'photo', [
    'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
    'length' => 256,
    'nullable' => true,
    'default' => null,
    'comment' => 'Admin user profile photo link'
]);

$installer->endSetup();