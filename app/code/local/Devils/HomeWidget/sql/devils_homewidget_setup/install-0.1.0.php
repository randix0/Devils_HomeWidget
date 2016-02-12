<?php
/** @var Devils_HomeWidget_Model_Resource_Setup $installer */
$installer = $this;
$installer->startSetup();

/**
 * Create table 'devils_homewidget/image'
 */
$installer->getConnection()->dropTable($installer->getTable('devils_homewidget/image'));
$table = $installer->getConnection()
    ->newTable($installer->getTable('devils_homewidget/image'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Entity ID')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true
    ), 'Name')
    ->addColumn('url_path', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        'nullable'  => false,
    ), 'URL Path')
    ->addColumn('image', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true
    ), 'Image')
    ->addColumn('resize_mode', Varien_Db_Ddl_Table::TYPE_TEXT, 10, array(
        'nullable'  => true
    ), 'Resize Mode')
    ->addColumn('size_code', Varien_Db_Ddl_Table::TYPE_TEXT, 20, array(
        'nullable'  => true
    ), 'Size Code')
    ->addColumn('width', Varien_Db_Ddl_Table::TYPE_INTEGER, 4, array(
        'nullable'  => false
    ), 'Width')
    ->addColumn('height', Varien_Db_Ddl_Table::TYPE_INTEGER, 4, array(
        'nullable'  => false
    ), 'Height')
    ->addColumn('position', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'default'   => '0',
    ), 'Sort Order')
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'default'   => '1',
    ), 'Is Image Active')
    ->setComment('Devils HomeWidget Image Table');
$installer->getConnection()->createTable($table);

/**
 * Create table 'devils_homewidget/image_store'
 */
$installer->getConnection()->dropTable($installer->getTable('devils_homewidget/image_store'));
$table = $installer->getConnection()
    ->newTable($installer->getTable('devils_homewidget/image_store'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'primary'   => true,
    ), 'Entity ID')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Store ID')
    ->addIndex($installer->getIdxName('devils_homewidget/image_store', array('store_id')),
        array('store_id'))
    ->addForeignKey($installer->getFkName('devils_homewidget/image_store', 'page_id', 'devils_homewidget/image', 'entity_id'),
        'entity_id', $installer->getTable('devils_homewidget/image'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('devils_homewidget/image_store', 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Devils HomeWidget Image To Store Linkage Table');
$installer->getConnection()->createTable($table);

$installer->endSetup();
