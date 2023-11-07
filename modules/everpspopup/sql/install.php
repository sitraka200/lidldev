<?php
/**
 * Project : everpspopup
 * @author Team Ever
 * @copyright Team Ever
 * @license   Tous droits réservés / Le droit d'auteur s'applique (All rights reserved / French copyright law applies)
 * @link https://www.team-ever.com
 */

/* Init */
$sql = array();

/* Create Tables in Database */
$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'everpspopup` (
         `id_everpspopup` int(10) unsigned NOT NULL auto_increment,
         `id_shop` int(10) unsigned NOT NULL,
         `unlogged` tinyint(1) unsigned DEFAULT NULL,
         `newsletter` tinyint(1) unsigned DEFAULT NULL,
         `bgcolor` varchar(255) DEFAULT NULL,
         `controller_array` int(10) unsigned DEFAULT NULL,
         `categories` varchar(255) DEFAULT NULL,
         `cookie_time` int(10) unsigned DEFAULT NULL,
         `adult_mode` int(10) unsigned DEFAULT NULL,
         `delay` int(10) unsigned DEFAULT NULL,
         `date_start` DATE DEFAULT NULL,
         `date_end` DATE DEFAULT NULL,
         `active` int(10) DEFAULT NULL,
         PRIMARY KEY (`id_everpspopup`))
         ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'everpspopup_lang` (
         `id_everpspopup` int(10) unsigned NOT NULL,
         `id_lang` int(10) unsigned NOT NULL,
         `name` varchar(255) DEFAULT NULL,
         `content` text DEFAULT NULL,
         `link` varchar(255) DEFAULT NULL,
         PRIMARY KEY (`id_everpspopup`, `id_lang`))
         ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

foreach ($sql as $s) {
    if (!Db::getInstance()->execute($s)) {
        return false;
    }
}
