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

$sql[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'everpspopup`;';
$sql[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'everpspopup_lang`;';

foreach ($sql as $s) {
    if (!Db::getInstance()->execute($s)) {
        return false;
    }
}
