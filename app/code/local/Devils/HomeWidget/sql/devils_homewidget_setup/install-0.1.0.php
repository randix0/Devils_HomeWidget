<?php

$installer = $this;
$installer->startSetup();
$table = $installer->run("
DROP TABLE IF EXISTS {$this->getTable('devils_homewidget_images')};
CREATE TABLE {$this->getTable('devils_homewidget_images')} (
  `entity_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL DEFAULT '',
  `link` text NOT NULL DEFAULT '',
  `image` VARCHAR(255) NOT NULL,
  `size_code` VARCHAR(20) NOT NULL,
  `width` int(4) NOT NULL,
  `height` int(4) NOT NULL,
  `position` int(10) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`entity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
$installer->endSetup();
