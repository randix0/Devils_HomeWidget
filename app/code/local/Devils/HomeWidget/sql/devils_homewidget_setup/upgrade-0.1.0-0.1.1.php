<?php
/** @var Devils_HomeWidget_Model_Resource_Setup $installer */
$installer = $this;
$installer->startSetup();

/**
 * Create table 'devils_homewidget/image_area'
 */
$installer->getConnection()->dropTable($installer->getTable('devils_homewidget/image_area'));
$table = $installer->getConnection()
    ->newTable($installer->getTable('devils_homewidget/image_area'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'primary'   => true,
    ), 'Entity ID')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true
    ), 'Name')
    ->addColumn('url_path', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        'nullable'  => false,
    ), 'URL Path')
    ->addColumn('points', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        'nullable'  => false
    ), 'Points')
    ->addForeignKey($installer->getFkName('devils_homewidget/image_area', 'entity_id', 'devils_homewidget/image', 'entity_id'),
        'entity_id', $installer->getTable('devils_homewidget/image'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Devils HomeWidget Image Areas Table');
$installer->getConnection()->createTable($table);

$installer->endSetup();