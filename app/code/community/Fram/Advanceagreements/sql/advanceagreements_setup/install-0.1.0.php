<?php
$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('advanceagreements/group'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'auto_increment' => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Id')
    ->addColumn('agreement_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
    ), 'Agreement Id')
    ->addColumn('customer_group_id', Varien_Db_Ddl_Table::TYPE_TEXT, null,
        array(
        'unsigned'  => true,
        'nullable'  => true,
    ), 'Customer Group Id')
    ->setComment('Checkout Agreement Customer Group Id');
$installer->getConnection()->createTable($table);

$installer->endSetup();


