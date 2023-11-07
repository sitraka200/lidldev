<?php
/**
* 2007-2018 PrestaShop
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
*  @copyright 2007-2018 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

include_once(_PS_MODULE_DIR_.'privateshop/privateshop.php');
class PrivateShopRestrictedModuleFrontController extends ModuleFrontController
{

    public function __construct()
    {
        parent::__construct();
        $this->context = Context::getContext();
    }

    public function init()
    {
        parent::init();
        if (Tools::version_compare(_PS_VERSION_, '1.7.0.0', '<') == true) {
            $this->display_header = false;
            $this->display_footer = false;
        }
    }
    
    public function initContent()
    {
        parent::initContent();
        $use_ssl = ((isset($this->ssl) && $this->ssl && Configuration::get('PS_SSL_ENABLED')) || Tools::usingSecureMode()) ? true : false;
        $protocol_content = ($use_ssl) ? 'https://' : 'http://';
        $metas = Meta::getMetaByPage('module-privateshop-restricted', $this->context->language->id);
        $field_values = $this->getConfigurationValues();
        $version = (Tools::version_compare(_PS_VERSION_, '1.7.0.0', '>=') == true) ? 1 : 0;
        $this->context->smarty->assign(array(
            'meta_title' => $metas['title'],
            'meta_description' => $metas['description'],
            'meta_keywords' => $metas['keywords'],
            'field_values' => $field_values,
            'version' => (int)$version,
            'modules_dir' => _MODULE_DIR_,
            'css_dir' => _THEME_CSS_DIR_,
            'favicon_url' => _PS_IMG_.Configuration::get('PS_FAVICON'),
            'img_update_time' => Configuration::get('PS_IMG_UPDATE_TIME'),
            'shop_name' => Configuration::get('PS_SHOP_NAME'),
            'request_uri' => Tools::safeOutput(urldecode($_SERVER['REQUEST_URI'])),
            'logo_url' => $this->context->link->getMediaLink(_PS_IMG_.Configuration::get('PS_LOGO')),
            'language_code' => $this->context->language->language_code ? $this->context->language->language_code : $this->context->language->iso_code,
            'base_uri' => $protocol_content.Tools::getHttpHost().__PS_BASE_URI__.(!Configuration::get('PS_REWRITING_SETTINGS') ? 'index.php' : ''),
        ));
        if (Tools::version_compare(_PS_VERSION_, '1.7.0.0', '>=') == true) {
            $this->setTemplate('module:privateshop/views/templates/front/restricted.tpl');
        }
        else {
            $this->setTemplate('restricted.tpl');
        }
    }
    
    protected function getConfigurationValues()
    {
        $bg_video = rtrim(Configuration::get('BACKGROUND_VIDEO'), '/');
        $bg_video = explode('/', $bg_video);
        $bg_video = end($bg_video);
        $bg_opacity = empty(Configuration::get('BG_OPACITY')) ? 1 : Configuration::get('BG_OPACITY');
        $conf_values = array(
            'PRIVATIZE_SHOP' => Configuration::get('PRIVATIZE_SHOP'),
            'login_title' => Configuration::get('LOGIN_TITLE', (int)$this->context->language->id),
            'signup_title' => Configuration::get('SIGNUP_TITLE', (int)$this->context->language->id),
            'position' => Configuration::get('FORM_POSITION'),
            'active_signup' => Configuration::get('PRIVATE_SIGNUP'),
            'bg_type' => Configuration::get('BACKGROUND_TYPE'),
            'bg_color' => Configuration::get('BACKGROUND_COLOR'),
            'bg_img' => Configuration::get('bg_image'),
            'allowed_ip' => Configuration::get('ACCESS_GRANTED_IP'),
            'products' => Configuration::get('private_products'),
            'category' => Configuration::get('categoryBox'),
            'bg_video' => $bg_video,
            'bg_opacity' => $bg_opacity,
            'bg_video_img' => Configuration::get('BACKGROUND_VIDEO_IMG'),
            'pages' => Configuration::get('cms_pages'),
            'restrict_message' => Configuration::get('PRIVATE_RESTRICT_MESSAGE', (int)$this->context->language->id));
        return $conf_values;
    }
}