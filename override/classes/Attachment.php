<?php
/**
 * 2007-2019 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2019 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */
/**
 * Class Attachment
 */
class Attachment extends AttachmentCore
{
    /**
     * Get All attachments.
     *
     * @param int $idLang Language ID
     *
     * @return array|false|mysqli_result|PDOStatement|resource|null Database query result
     */
    /*
    * module: ac_filedownload
    * date: 2019-09-12 00:24:34
    * version: 1.0.0
    */
    public static function getAllAttachments($idLang)
    {
        return Db::getInstance()->executeS(
            '
			SELECT *
			FROM ' . _DB_PREFIX_ . 'attachment a
			LEFT JOIN ' . _DB_PREFIX_ . 'attachment_lang al
				ON (a.id_attachment = al.id_attachment AND al.id_lang = ' . (int) $idLang . ')
			ORDER BY a.id_attachment DESC'
        );
    }
}
