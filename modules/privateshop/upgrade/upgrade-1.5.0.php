<?php
/**
* DISCLAIMER
*
* Do not edit or add to this file.
* You are not authorized to modify, copy or redistribute this file.
* Permissions are reserved by FME Modules.
*
*  @author    FMM Modules
*  @copyright FME Modules 2018
*  @license   Single domain
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_1_5_0($module)
{
    Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'privateshop_urls`(
            `id_privateshop_urls` int(11) NOT NULL auto_increment,
            `url` varchar(255) NOT NULL,
            PRIMARY KEY (`id_privateshop_urls`))
            ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8'
        );
    return true;
}