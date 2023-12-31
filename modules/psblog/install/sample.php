<?php
/**
* 2007-2016 PrestaShop
 *
* NOTICE OF LICENSE
 *               
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2016 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registred Trademark & Property of PrestaShop SA
 */

$langs = Language::getLanguages(false);
$res = (bool)Db::getInstance()->execute(' TRUNCATE TABLE `'._DB_PREFIX_.'psblogcat`  ');
$res = (bool)Db::getInstance()->execute('INSERT INTO `'._DB_PREFIX_."psblogcat`  (`id_psblogcat`, `image`, `id_parent`, `item`, `level_depth`, `active`, `position`, `submenu_content`, `privacy`, `position_type`, `menu_class`, `content`, `icon_class`, `level`, `left`, `right`, `date_add`, `date_upd`, `template`) VALUES
(1, '', 0, NULL, 0, 0, 0, '', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, ''),
(3, 'category-3.jpg', 1, '', 1, 1, 0, '', 0, '', '', '', '', 0, 0, 0, '2013-11-27 01:06:52', '2013-12-18 03:07:22', 'default'),
(4, 'category-2.jpg', 3, '', 2, 1, 0, '', 0, '', '', '', '', 0, 0, 0, '2013-11-27 01:07:34', '2013-12-18 03:07:50', 'default'),
(5, 'category-1.jpg', 3, NULL, 2, 1, 1, '', 0, NULL, '', NULL, '', 0, 0, 0, '2013-12-16 08:44:07', '2013-12-18 03:05:46', 'default');
");

$res = (bool)Db::getInstance()->execute(' TRUNCATE TABLE `'._DB_PREFIX_.'psblogcat_lang`  ');

foreach ($langs as $l) {
    $sql = 'INSERT INTO `'._DB_PREFIX_."psblogcat_lang` (`id_psblogcat`, `id_lang`, `title`, `content_text`, `description`, `meta_keywords`, `meta_description`, `link_rewrite`) VALUES
		(1, LANGUAGEID, 'Root', NULL, '', '', '', ''),
		(3, LANGUAGEID, 'Vestibulum consequat', '<p>Sed mauris Pellentesque elit Aliquam at lacus interdum nascetur elit ipsum. Enim ipsum hendrerit Suspendisse turpis laoreet fames tempus ligula pede ac. Et Lorem penatibus orci eu ultrices egestas Nam quam Vivamus nibh. Morbi condimentum molestie Nam enim odio sodales pretium eros sem pellentesque. </p>', '', '', '\r\n', 'category-1'),
		(4, LANGUAGEID, 'Pellentesque condimentum', '<p>Mi vitae magnis Fusce laoreet nibh felis porttitor laoreet Vestibulum faucibus. At Nulla id tincidunt ut sed semper vel Lorem condimentum ornare. Laoreet Vestibulum lacinia massa a commodo habitasse velit Vestibulum tincidunt In. Turpis at eleifend ps mi elit Aenean porta ac sed faucibus.</p>', '', 'joomla,prestashop,pstheme,pavothemes', '', 'sub-category-1'),
		(5, LANGUAGEID, 'Suspendisse turpis', '<p>Commodo laoreet semper tincidunt lorem Vestibulum nunc at In Curabitur magna. Euismod euismod Suspendisse tortor ante adipiscing risus Aenean Lorem vitae id. Odio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor Aenean nulla lacinia Nullam elit vel vel.</p>', '', 'prestashop,joomla,magento', 'gogogoel', 'sub-category-2');
		";
    $sql = str_replace('LANGUAGEID', $l['id_lang'], $sql);
    $res = (bool)Db::getInstance()->execute($sql);
}

$res = (bool)Db::getInstance()->execute(' TRUNCATE TABLE `'._DB_PREFIX_.'psblogcat_shop`  ');
$res = (bool)Db::getInstance()->execute('INSERT INTO `'._DB_PREFIX_.'psblogcat_shop` (`id_psblogcat`, `id_shop`) VALUES
(1, 1),
(3, 1),
(4, 1),
(5, 1); ');

$res = (bool)Db::getInstance()->execute(' TRUNCATE TABLE `'._DB_PREFIX_.'psblog_blog`  ');
$res = (bool)Db::getInstance()->execute('INSERT INTO `'._DB_PREFIX_."psblog_blog` (`id_psblog_blog`, `id_psblogcat`, `position`, `date_add`, `active`, `user_id`, `hits`, `image`, `thumb`, `date_upd`, `video_code`, `params`, `featured`, `indexation`, `id_employee`, `product_ids`) VALUES
(3, 4, 0, '2013-11-28', 1, 0, 40, 'b-blog-1.jpg', '', '2016-12-20 09:55:38', '<iframe width=\"560\" height=\"315\" src=\"//www.youtube.com/embed/lzY4lkT8ElU\" frameborder=\"0\" allowfullscreen></iframe>', '', 0, 1, 1, ''),
(4, 4, 2, '2013-12-04', 1, 0, 105, 'b-blog-2.jpg', '', '2016-12-18 06:31:14', '', '', 0, 1, 1, ''),
(5, 4, 3, '2013-12-16', 1, 0, 9, 'b-blog-3.jpg', '', '2016-12-19 01:21:28', '', '', 0, 0, 1, ''),
(6, 4, 4, '2013-12-18', 1, 0, 121, 'b-blog-4.jpg', '', '2016-12-20 09:54:03', '', '', 0, 0, 1, ''),
(7, 4, 5, '2013-12-18', 1, 0, 71, 'b-blog-5.jpg', '', '2016-12-20 01:04:46', '', '', 0, 0, 1, ''),
(8, 4, 1, '2013-12-18', 1, 0, 3, 'b-blog-6.jpg', '', '2016-12-19 22:50:10', '', '', 0, 0, 1, ''),
(9, 4, 6, '2013-12-18', 1, 0, 0, 'b-blog-7.jpg', '', '2016-12-18 03:32:42', '', '', 0, 1, 1, '');
");


$res = (bool)Db::getInstance()->execute(' TRUNCATE TABLE `'._DB_PREFIX_.'psblog_blog_lang`  ');


foreach ($langs as $l) {
    $sql = 'INSERT INTO `'._DB_PREFIX_."psblog_blog_lang`  (`id_psblog_blog`, `id_lang`, `meta_description`, `meta_keywords`, `meta_title`, `link_rewrite`, `content`, `description`, `tags`) VALUES
	(3, LANGUAGEID, '', '', 'At risus pretium urna tortor metus fringilla', 'at-risus-pretium-urna-tortor-metus-fringilla', '<p>Odio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor. At risus pretium urna tortor metus fringilla interdum mauris tempor congue Odio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor. At risus pretium urna tortor metus fringilla interdum mauris tempor congue Odio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor. At risus pretium urna tortor metus fringilla interdum mauris tempor congue</p>\r\n<p> </p>\r\n<p>Odio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor. At risus pretium urna tortor metus fringilla interdum mauris tempor congue</p>\r\n<p> </p>\r\n<p>Odio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor. At risus pretium urna tortor metus fringilla interdum mauris tempor congue Odio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor. At risus pretium urna tortor metus fringilla interdum mauris tempor congue</p>\r\n<p> </p>\r\n<p>Odio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor. At risus pretium urna tortor metus fringilla interdum mauris tempor congue Odio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor. At risus pretium urna tortor metus fringilla interdum mauris tempor congue</p>', '<p>Odio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor. At risus pretium urna tortor metus fringilla interdum mauris tempor congue</p>', 'joomla,wordpress'),
	(4, LANGUAGEID, '', '', 'Ipsum cursus vestibulum at interdum Vivamus', 'ipsum-cursus-vestibulum-at-interdum-vivamus', '<p>Donec tellus Nulla lorem Nullam elit id ut elit feugiat lacus. Congue eget dapibus congue tincidunt senectus nibh risus Phasellus tristique justo. Justo Pellentesque Donec lobortis faucibus Vestibulum Praesent mauris volutpat vitae metus. Ipsum cursus vestibulum at interdum Vivamus nunc fringilla Curabitur ac quis. Nam lacinia wisi tortor orci quis vitae. Donec tellus Nulla lorem Nullam elit id ut elit feugiat lacus. Congue eget dapibus congue tincidunt senectus nibh risus Phasellus tristique justo. Justo Pellentesque Donec lobortis faucibus Vestibulum Praesent mauris volutpat vitae metus. Ipsum cursus vestibulum at interdum Vivamus nunc fringilla Curabitur ac quis. Nam lacinia wisi tortor orci quis vitae. Donec tellus Nulla lorem Nullam elit id ut elit feugiat lacus. Congue eget dapibus congue tincidunt senectus nibh risus Phasellus tristique justo. Justo Pellentesque Donec lobortis faucibus Vestibulum Praesent mauris volutpat vitae metus. Ipsum cursus vestibulum at interdum Vivamus nunc fringilla Curabitur ac quis. Nam lacinia wisi tortor orci quis vitae.</p>\r\n<p>Donec tellus Nulla lorem Nullam elit id ut elit feugiat lacus. Congue eget dapibus congue tincidunt senectus nibh risus Phasellus tristique justo. Justo Pellentesque Donec lobortis faucibus Vestibulum Praesent mauris volutpat vitae metus. Ipsum cursus vestibulum at interdum Vivamus nunc fringilla Curabitur ac quis. Nam lacinia wisi tortor orci quis vitae.Donec tellus Nulla lorem Nullam elit id ut elit feugiat lacus. Congue eget dapibus congue tincidunt senectus nibh risus Phasellus tristique justo. Justo Pellentesque Donec lobortis faucibus Vestibulum Praesent mauris volutpat vitae metus. Ipsum cursus vestibulum at interdum Vivamus nunc fringilla Curabitur ac quis. Nam lacinia wisi tortor orci quis vitae.Donec tellus Nulla lorem Nullam elit id ut elit feugiat lacus. Congue eget dapibus congue tincidunt senectus nibh risus Phasellus tristique justo. Justo Pellentesque Donec lobortis faucibus Vestibulum Praesent mauris volutpat vitae metus. Ipsum cursus vestibulum at interdum Vivamus nunc fringilla Curabitur ac quis. Nam lacinia wisi tortor orci quis vitae.</p>', '<p>Donec tellus Nulla lorem Nullam elit id ut elit feugiat lacus. Congue eget dapibus congue tincidunt senectus nibh risus Phasellus tristique justo. Justo Pellentesque Donec lobortis faucibus</p>', 'joomla,prestashop,pstheme'),
	(5, LANGUAGEID, '', 'joomla,prestashop,pstheme,prestashop theme', 'Urna pretium elit mauris cursus Curabitur at elit Vestibulum', 'urna-pretium-elit-mauris-cursus-curabitur-at-elit-vestibulum', '<p>Mi vitae magnis Fusce laoreet nibh felis porttitor laoreet Vestibulum faucibus. At Nulla id tincidunt ut sed semper vel Lorem condimentum ornare. Laoreet Vestibulum lacinia massa a commodo habitasse velit Vestibulum tincidunt In. Turpis at eleifend ps mi elit Aenean porta ac sed faucibus. Nunc urna Morbi fringilla vitae orci convallis condimentum auctor sit dui. Urna pretium elit mauris cursus Curabitur at elit Vestibulum.</p>', '<p>Mi vitae magnis Fusce laoreet nibh felis porttitor laoreet Vestibulum faucibus. At Nulla id tincidunt ut sed semper vel Lorem condimentum ornare.</p>', 'Joomla'),
	(6, LANGUAGEID, '', '', 'Urna pretium elit mauris cursus Curabitur at elit Vestibulum', 'urna-pretium-elit-mauris-cursus-curabitur-at-elit-vestibulum', '<p>Mi vitae magnis Fusce laoreet nibh felis porttitor laoreet Vestibulum faucibus. At Nulla id tincidunt ut sed semper vel Lorem condimentum ornare. Laoreet Vestibulum lacinia massa a commodo habitasse velit Vestibulum tincidunt In. Turpis at eleifend ps mi elit Aenean porta ac sed faucibus. Nunc urna Morbi fringilla vitae orci convallis condimentum auctor sit dui. Urna pretium elit mauris cursus Curabitur at elit Vestibulum. Mi vitae magnis Fusce laoreet nibh felis porttitor laoreet Vestibulum faucibus. At Nulla id tincidunt ut sed semper vel Lorem condimentum ornare. Laoreet Vestibulum lacinia massa a commodo habitasse velit Vestibulum tincidunt In. Turpis at eleifend ps mi elit Aenean porta ac sed faucibus. Nunc urna Morbi fringilla vitae orci convallis condimentum auctor sit dui. Urna pretium elit mauris cursus Curabitur at elit Vestibulum.</p>', '<p>Mi vitae magnis Fusce laoreet nibh felis porttitor laoreet Vestibulum faucibus. At Nulla id tincidunt ut sed semper vel Lorem condimentum ornare.</p>', 'pstheme,prestashop,theme'),
	(7, LANGUAGEID, '', '', 'Morbi condimentum molestie Nam enim odio sodales', 'morbi-condimentum-molestie-nam-enim-odio-sodales', '<p>Odio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor. At risus pretium urna tortor metus fringilla interdum mauris tempor congue.</p><p>Commodo laoreet semper tincidunt lorem Vestibulum nunc at In Curabitur magna. Euismod euismod Suspendisse tortor ante adipiscing risus Aenean Lorem vitae id. Odio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor Aenean nulla lacinia Nullam elit vel vel. At risus pretium urna tortor metus fringilla interdum mauris tempor congue.</p><p>Donec tellus Nulla lorem Nullam elit id ut elit feugiat lacus. Congue eget dapibus congue tincidunt senectus nibh risus Phasellus tristique justo. Justo Pellentesque Donec lobortis faucibus Vestibulum Praesent mauris volutpat vitae metus. Ipsum cursus vestibulum at interdum Vivamus nunc fringilla Curabitur ac quis. Nam lacinia wisi tortor orci quis vitae.</p><p>Sed mauris Pellentesque elit Aliquam at lacus interdum nascetur elit ipsum. Enim ipsum hendrerit Suspendisse turpis laoreet fames tempus ligula pede ac. Et Lorem penatibus orci eu ultrices egestas Nam quam Vivamus nibh. Morbi condimentum molestie Nam enim odio sodales pretium eros sem pellentesque. Sit tellus Integer elit egestas lacus turpis id auctor nascetur ut. Ac elit vitae.</p><p>Mi vitae magnis Fusce laoreet nibh felis porttitor laoreet Vestibulum faucibus. At Nulla id tincidunt ut sed semper vel Lorem condimentum ornare. Laoreet Vestibulum lacinia massa a commodo habitasse velit Vestibulum tincidunt In. Turpis at eleifend ps mi elit Aenean porta ac sed faucibus. Nunc urna Morbi fringilla vitae orci convallis condimentum auctor sit dui. Urna pretium elit mauris cursus Curabitur at elit Vestibulum.</p>', '<p>Sed mauris Pellentesque elit Aliquam at lacus interdum nascetur elit ipsum. Enim ipsum hendrerit Suspendisse turpis laoreet fames tempus ligula pede ac. Et Lorem penatibus orci eu ultrices egestas Nam quam Vivamus nibh.</p>', 'pstheme,prestashop,magento,opencart'),
	(8, LANGUAGEID, '', '', 'Turpis at eleifend ps mi elit Aenean porta ac sed faucibus', 'turpis-at-eleifend-ps-mi-elit-aenean-porta-ac-sed-faucibus', '<p>Odio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor. At risus pretium urna tortor metus fringilla interdum mauris tempor congue.</p><p>Commodo laoreet semper tincidunt lorem Vestibulum nunc at In Curabitur magna. Euismod euismod Suspendisse tortor ante adipiscing risus Aenean Lorem vitae id. Odio ut pretium ligula quam Vestibulum consequat convallis fringilla Vestibulum nulla. Accumsan morbi tristique auctor Aenean nulla lacinia Nullam elit vel vel. At risus pretium urna tortor metus fringilla interdum mauris tempor congue.</p>\r\n<p>Donec tellus Nulla lorem Nullam elit id ut elit feugiat lacus. Congue eget dapibus congue tincidunt senectus nibh risus Phasellus tristique justo. Justo Pellentesque Donec lobortis faucibus Vestibulum Praesent mauris volutpat vitae metus. Ipsum cursus vestibulum at interdum Vivamus nunc fringilla Curabitur ac quis. Nam lacinia wisi tortor orci quis vitae.</p>\r\n<p>Sed mauris Pellentesque elit Aliquam at lacus interdum nascetur elit ipsum. Enim ipsum hendrerit Suspendisse turpis laoreet fames tempus ligula pede ac. Et Lorem penatibus orci eu ultrices egestas Nam quam Vivamus nibh. Morbi condimentum molestie Nam enim odio sodales pretium eros sem pellentesque. Sit tellus Integer elit egestas lacus turpis id auctor nascetur ut. Ac elit vitae.</p>\r\n<p>Mi vitae magnis Fusce laoreet nibh felis porttitor laoreet Vestibulum faucibus. At Nulla id tincidunt ut sed semper vel Lorem condimentum ornare. Laoreet Vestibulum lacinia massa a commodo habitasse velit Vestibulum tincidunt In. Turpis at eleifend ps mi elit Aenean porta ac sed faucibus. Nunc urna Morbi fringilla vitae orci convallis condimentum auctor sit dui. Urna pretium elit mauris cursus Curabitur at elit Vestibulum.</p>', '<p>Turpis at eleifend ps mi elit Aenean porta ac sed faucibus. Nunc urna Morbi fringilla vitae orci convallis condimentum auctor sit dui. Urna pretium elit mauris cursus Curabitur at elit Vestibulum</p>', 'magento,opencart,template'),
	(9, LANGUAGEID, '', '', 'Nullam ullamcorper nisl quis ornare molestie', 'nullam-ullamcorper-nisl-quis-ornare-molestie', '<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quas.</p><p>Suspendisse posuere, diam in bibendum lobortis, turpis ipsum aliquam risus, sit amet dictum ligula lorem non nisl. Ut vitae nibh id massa vulputate euismod ut quis justo. Ut bibendum sem at massa lacinia, eget elementum ante consectetur. Nulla id pharetra dui, at rhoncus urna. Maecenas non porttitor purus. Nullam ullamcorper nisl quis ornare molestie.</p>\r\n<p>Etiam eget erat est. Phasellus elit justo, mattis non lorem non, aliquam aliquam ps. Sed fermentum consectetur magna, eget semper ante. Aliquam scelerisque justo velit. Fusce cursus blandit dolor, in sodales urna vulputate lobortis. Nulla ut tellus turpis. Nullam lacus sem, volutpat id odio sed, cursus tristique eros. Duis at pellentesque magna. Donec magna nisi, vulputate ac nulla eu, ultricies tincidunt tellus. Nunc tincidunt sem urna, nec venenatis libero vehicula ut.</p>\r\n<p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Curabitur faucibus aliquam pulvinar. Vivamus mattis volutpat erat, et congue nisi semper quis. Cras vehicula dignissim libero in elementum. Mauris sit amet dolor justo. Morbi consequat velit vel est fermentum euismod. Curabitur in magna augue.</p>', '<p>Suspendisse posuere, diam in bibendum lobortis, turpis ipsum aliquam risus, sit amet dictum ligula lorem non nisl Urna pretium elit mauris cursus Curabitur at elit Vestibulum</p>', 'opencart,theme');
	";
    $sql = str_replace('LANGUAGEID', $l['id_lang'], $sql);
    $res = (bool)Db::getInstance()->execute($sql);
}

$res = (bool)Db::getInstance()->execute(' TRUNCATE TABLE `'._DB_PREFIX_.'psblog_blog_shop`  ');
$res = (bool)Db::getInstance()->execute('INSERT INTO `'._DB_PREFIX_.'psblog_blog_shop` (`id_psblog_blog`, `id_shop`) VALUES
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1); ');

$res = (bool)Db::getInstance()->execute(' TRUNCATE TABLE `'._DB_PREFIX_.'psblog_comment`  ');
$res = (bool)Db::getInstance()->execute('INSERT INTO `'._DB_PREFIX_."psblog_comment` (`id_comment`, `id_shop` , `id_psblog_blog`, `comment`, `active`, `date_add`, `user`, `email`) VALUES
(3, 1, 3, ' At Nulla id tincidunt ut sed semper vel Lorem condimentum ornare. Laoreet Vestibulum lacinia massa a commodo habitasse velit Vestibulum tincidunt In', 1, '2013-12-11 22:18:13', 'ha cong tien', 'tienhc@brainos.vn'),
(4, 1, 3, ' At Nulla id tincidunt ut sed semper vel Lorem condimentum ornare. Laoreet Vestibulum lacinia massa a commodo habitasse velit Vestibulum tincidunt In', 1, '2013-12-11 22:18:33', 'ha cong tien', 'tienhc@brainos.vn');");
