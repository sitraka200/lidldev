<?php
/**
* PrivateShop
*
* Do not edit or add to this file.
* You are not authorized to modify, copy or redistribute this file.
* Permissions are reserved by FME Modules.
*
*  @author    FME Modules
*  @copyright 2019 FME Modules All right reserved
*  @license   FME Modules
*  @category  FMM Modules
*  @package   PrivateShop
*/
include_once(_PS_MODULE_DIR_.'privateshop/privateshop.php');
class FrontController extends FrontControllerCore
{
    /*
    * module: privateshop
    * date: 2019-09-24 20:15:05
    * version: 1.6.0
    */
    public function init()
    {
        parent::init();
        $id_customer = (int)Tools::getValue('id_customer');
        $uri = explode('/', $_SERVER['REQUEST_URI']);
        $uri = end($uri);
        $route = $this->getFriendlyModRoute($uri);
        $controller = Dispatcher::getInstance()->getController();
        $allowed_controllers = Configuration::get('MODULE_PAGES') && !empty(Configuration::get('MODULE_PAGES'))? explode(',', Configuration::get('MODULE_PAGES')) : array();
        $module_pages = Module::getInstanceByName('privateshop')->getAvailableControllers(true);
        $filtered_controllers = (isset($allowed_controllers ) && $allowed_controllers && isset($module_pages) && $module_pages)? array_intersect_key($module_pages, array_flip($allowed_controllers)) : array();
        $filtered_controllers = isset($filtered_controllers) && $filtered_controllers? array_values($filtered_controllers) : array();
        $scheme = 'http';
        if (array_key_exists('REQUEST_SCHEME', $_SERVER)) {
            $scheme = $_SERVER['REQUEST_SCHEME'];
        }
        $base_url = $scheme.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $whitelisted_url = (int)$this->checkIfWhitelistedUrl($base_url);
        if ($controller == 'restricted' || $controller == 'thejax' || $controller == 'Privatesearch' || (!empty($route) && preg_match('/private/', $route))) {
        } elseif (isset($filtered_controllers) && $filtered_controllers && in_array($controller, $filtered_controllers)) {
        } elseif ($whitelisted_url > 0) {
        } else {
            if (Tools::version_compare(_PS_VERSION_, '1.7.0.0', '>=') == true && (Tools::getValue('token')) && ($id_customer)) {
            }
            $shops = PrivateShop::getAssocShops();
            if ((Shop::isFeatureActive() && isset($shops) && in_array($this->context->shop->id, $shops)) || !Shop::isFeatureActive() || empty($shops)) {
                if ((Tools::isSubmit('submitCreate') || Tools::isSubmit('create_account')) && $id_customer <= 0) {
                } else {
                    self::privateProcess();
                }
            }
        }
    }
    
    /*
    * module: privateshop
    * date: 2019-09-24 20:15:05
    * version: 1.6.0
    */
    protected function initPrivate()
    {
        $use_ssl = ((isset($this->ssl) && $this->ssl && Configuration::get('PS_SSL_ENABLED')) || Tools::usingSecureMode()) ? true : false;
        $protocol_content = ($use_ssl) ? 'https://' : 'http://';
        $this->context->smarty->assign(Meta::getMetaTags($this->context->language->id, 'private_login'));
        $this->assignDate();
        $this->context->smarty->assign(array(
            'modules_dir' => _MODULE_DIR_,
            'js_dir' => _THEME_JS_DIR_,
            'js_def' => Media::getJsDef(),
            'countries' => Country::getCountries($this->context->language->id, true),
            'version' => _PS_VERSION_,
            'css_dir' => _THEME_CSS_DIR_,
            'tpl_dir' => _PS_THEME_DIR_,
            'errors' => $this->errors,
            'token' => Tools::getToken(),
            'js_files' => Media::getJqueryPath(),
            'date_format' => $this->context->language->date_format_lite,
            'favicon_url' => _PS_IMG_.Configuration::get('PS_FAVICON'),
            'img_update_time' => Configuration::get('PS_IMG_UPDATE_TIME'),
            'shop_name' => Configuration::get('PS_SHOP_NAME'),
            'is_logged' => (bool)$this->context->customer->isLogged(),
            'is_guest' => (bool)$this->context->customer->isGuest(),
            'request_uri' => Tools::safeOutput(urldecode($_SERVER['REQUEST_URI'])),
            'logo_url' => $this->context->link->getMediaLink(_PS_IMG_.Configuration::get('PS_LOGO')),
            'language_code' => $this->context->language->language_code ? $this->context->language->language_code : $this->context->language->iso_code,
            'base_uri' => $protocol_content.Tools::getHttpHost().__PS_BASE_URI__.(!Configuration::get('PS_REWRITING_SETTINGS') ? 'index.php' : ''),
            ));
    }
    /*
    * module: privateshop
    * date: 2019-09-24 20:15:05
    * version: 1.6.0
    */
    protected function getConfigurationValues()
    {
        $bg_video = rtrim(Configuration::get('BACKGROUND_VIDEO'), '/');
        $bg_video = explode('/', $bg_video);
        $bg_video = end($bg_video);
        $bg_opacity = empty(Configuration::get('BG_OPACITY')) ? 1 : Configuration::get('BG_OPACITY');
        $theme = (empty(Configuration::get('PRIVATE_FORM_THEME'))) ? 'mod' : Configuration::get('PRIVATE_FORM_THEME');
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
            'bday' => Configuration::get('PRIVATE_BDAY'),
            'gender_opt' => Configuration::get('PRIVATE_GENDER_OPT'),
            'nletter_opt' => Configuration::get('PRIVATE_NLETTER_OPT'),
            'offers_opt' => Configuration::get('PRIVATE_OFFERS_OPT'),
            'custom_logo' => Configuration::get('PRIVATE_CUSTOM_LOGO'),
            'custom_logo_img' => Configuration::get('PRIVATE_CUSTOM_LOGO_IMG'),
            'category' => Configuration::get('categoryBox'),
            'bg_video' => $bg_video,
            'bg_video_img' => Configuration::get('BACKGROUND_VIDEO_IMG'),
            'show_store_title' => (int)Configuration::get('PRIVATE_SHOW_STORE_TITLE'),
            'bg_opacity' => $bg_opacity,
            'priv_form_theme' => $theme,
            'pages' => Configuration::get('cms_pages'),
            'restrict_message' => Configuration::get('PRIVATE_CUSTOMER_GROUP_MSG', (int)$this->context->language->id));
        return $conf_values;
    }
    /*
    * module: privateshop
    * date: 2019-09-24 20:15:05
    * version: 1.6.0
    */
    protected function privateLogin($persist = 0)
    {
        $persist = ((int)$persist > 0) ? $persist : (int)Tools::getValue('persist');
        
        $accessed_ips = '';
        $google_bot = (int)Configuration::get('PRIVATE_RESTRICT_GOOGLE');
        if (Configuration::get('ACCESS_GRANTED_IP')) {
            $accessed_ips = explode(',', Configuration::get('ACCESS_GRANTED_IP'));
        }
        if (!empty($accessed_ips) && !in_array(Tools::getRemoteAddr(), $accessed_ips) || Tools::getRemoteAddr() != Configuration::get('ACCESS_GRANTED_IP')) {
            if(strstr(Tools::strtolower($_SERVER['HTTP_USER_AGENT']), 'googlebot') && $google_bot > 0) {
            } else {
                $this->initPrivate();
                $field_values = $this->getConfigurationValues();
                $persist_restricted = (int)Context::getContext()->cookie->__get('privateshop_restricted');
                $this->context->smarty->assign('field_values', $field_values);
                $this->context->smarty->assign('persist', (int)$persist);
                $ajax_link = $this->context->link->getModuleLink('privateshop', 'thejax');
                $this->context->smarty->assign('ajax_link', $ajax_link);
                if (Tools::version_compare(_PS_VERSION_, '1.7.0.0', '>=') == true) {
                    $this->context->smarty->assign('link', $this->context->link);
                    $this->context->smarty->assign('hook_create_account_form', Hook::exec('displayCustomerAccountForm'));
                    $this->smartyOutputContent('module:privateshop/views/templates/front/private_login_17.tpl');
                } else {
                    $this->context->smarty->assign('persist_restricted', (int)$persist_restricted);
                    $this->context->smarty->assign('restrict_message', Configuration::get('PRIVATE_RESTRICT_MESSAGE', (int)$this->context->language->id));
                    $this->smartyOutputContent(_PS_MODULE_DIR_.'privateshop/views/templates/front/private_login.tpl');
                }
                die();
            }
        }
    }
    /*
    * module: privateshop
    * date: 2019-09-24 20:15:05
    * version: 1.6.0
    */
    protected function deadEnd()
    {
        $this->initPrivate();
        $field_values = $this->getConfigurationValues();
        $this->context->smarty->assign('field_values', $field_values);
        if (Tools::version_compare(_PS_VERSION_, '1.7.0.0', '>=') == true) {
            $this->smartyOutputContent('module:privateshop/views/templates/front/deadend.tpl');
        } else {
            $this->smartyOutputContent(_PS_MODULE_DIR_.'privateshop/views/templates/front/deadend.tpl');
        }
        die();
    }
    
    /*
    * module: privateshop
    * date: 2019-09-24 20:15:05
    * version: 1.6.0
    */
    protected function privateProcess()
    {
        $accessed_ips = '';
        $restricted_cat = array();
        $products = array();
        $cms_pages = array();
        $customer_group = (int)Configuration::get('PRIVATE_CUSTOMER_GROUP_STATE');
        $private_type = Configuration::get('PRIVATIZE_SHOP');
        $remote_ip = Tools::getRemoteAddr();
        $scheme = 'http';
        if (array_key_exists('REQUEST_SCHEME', $_SERVER)) {
            $scheme = $_SERVER['REQUEST_SCHEME'];
        }
        $base_url = $scheme.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $restricted_url = (int)$this->checkIfBlacklistedUrl($base_url);
        if (Configuration::get('ACCESS_GRANTED_IP')) {
            $accessed_ips = explode(',', Configuration::get('ACCESS_GRANTED_IP'));
        }
        if (Configuration::get('categoryBox')) {
            $restricted_cat = explode(',', Configuration::get('categoryBox'));
        }
        if (Configuration::get('private_products')) {
            $products = explode(',', Configuration::get('private_products'));
        }
        if (Configuration::get('cms_pages')) {
            $cms_pages = explode(',', Configuration::get('cms_pages'));
        }
        if ((is_array($restricted_cat) && (in_array(Configuration::get('PS_HOME_CATEGORY'), $restricted_cat))
            || Configuration::get('PS_HOME_CATEGORY') == Configuration::get('categoryBox'))
            && Tools::getValue('controller') == 'index') {
            self::privateLogin();
        }
        if (Tools::isSubmit('SubmitLogin') && $private_type == 'whole-shop') {
            $this->processSubmitLogin();
        } elseif (Tools::isSubmit('SubmitCreate') && Tools::version_compare(_PS_VERSION_, '1.7.0.0', '<') == true);
        elseif ((Tools::isSubmit('submitAccount') || Tools::isSubmit('submitGuestAccount')) && Tools::version_compare(_PS_VERSION_, '1.7.0.0', '<') == true) {
            $this->processSubmitAccount();
        } elseif (Tools::isSubmit('forgotpassword')) {
            $persist = true;
            $this->passwordRecovery();
            self::privateLogin($persist);
        } elseif (Tools::getValue('token') && (int)Tools::getValue('id_customer') && Tools::version_compare(_PS_VERSION_, '1.7.0.0', '<') == true) {
            $this->passwordRecovery();
            $persist = true;
            self::privateLogin($persist);
        } elseif (!$this->auth
            && !$this->context->customer->isLogged($this->guestAllowed)
            && ($private_type == 'whole-shop')
            && (!empty($accessed_ips) && !in_array($remote_ip, $accessed_ips) || $remote_ip != Configuration::get('ACCESS_GRANTED_IP'))
            && (Tools::getValue('controller') && Tools::getValue('controller') != 'search')) {
            self::privateLogin();
        } elseif (!$this->auth
            && !$this->context->customer->isLogged($this->guestAllowed)
            && ($private_type == 'selected-parts')
            && (!empty($accessed_ips) && !in_array($remote_ip, $accessed_ips) || $remote_ip != Configuration::get('ACCESS_GRANTED_IP'))
            && (Tools::getValue('controller') && Tools::getValue('controller') != 'search')
            && (Tools::getValue('controller') && Tools::getValue('controller') == 'cms' && Tools::getValue('id_cms') && in_array(Tools::getValue('id_cms'), $cms_pages))) {
            self::privateLogin();
        } elseif (!$this->auth
            && !$this->context->customer->isLogged($this->guestAllowed)
            && ($private_type == 'selected-parts')
            && (!empty($accessed_ips) && !in_array($remote_ip, $accessed_ips) || $remote_ip != Configuration::get('ACCESS_GRANTED_IP'))
            && (Tools::getValue('controller') && Tools::getValue('controller') != 'search')
            && (Tools::getValue('controller') && Tools::getValue('controller') == 'product' && Tools::getValue('id_product') && in_array(Tools::getValue('id_product'), $products))) {
            self::privateLogin();
        } elseif (!$this->auth
            && !$this->context->customer->isLogged($this->guestAllowed)
            && ($private_type == 'selected-parts')
            && (!empty($accessed_ips) && !in_array($remote_ip, $accessed_ips) || $remote_ip != Configuration::get('ACCESS_GRANTED_IP'))
            && (Tools::getValue('controller') && Tools::getValue('controller') != 'search')
            && (Tools::getValue('controller') && Tools::getValue('controller') == 'category' && Tools::getValue('id_category')))
        {
            $cur_category = new Category((int)Tools::getValue('id_category'));
            $parents = $cur_category->getParentsCategories($this->context->language->id);
            foreach ($parents as $parent) {
                if (in_array($parent['id_category'], $restricted_cat) || in_array(Tools::getValue('id_category'), $restricted_cat)) {
                    self::privateLogin();
                }
            }
        } elseif (!$this->auth
            && !$this->context->customer->isLogged($this->guestAllowed)
            && ($private_type == 'selected-parts')
            && (!empty($accessed_ips) && !in_array($remote_ip, $accessed_ips) || $remote_ip != Configuration::get('ACCESS_GRANTED_IP'))
            && $restricted_url > 0)
        {
            self::privateLogin();
        }//As of PrivateShop v1.6.0 - Customer group access check
        elseif ((int)$this->context->customer->id > 0 && $this->context->customer->isLogged() && $customer_group > 0) {
            $ip_flag = (!empty($accessed_ips) && (in_array($remote_ip, $accessed_ips) || $remote_ip == Configuration::get('ACCESS_GRANTED_IP'))) ? true : false;
            $customer_group_perm = (int)$this->getCustomerQualification((int)$this->context->customer->id);
            if ($customer_group_perm <= 0 && $ip_flag == false) {//Just for whole shop
                if ($private_type == 'whole-shop') {
                    $this->deadEnd();
                }//If only partial private shop
                elseif ($private_type == 'selected-parts') {
                    $controller = Tools::getValue('controller');
                    if ($controller && $controller == 'cms' && Tools::getValue('id_cms') &&  in_array(Tools::getValue('id_cms'), $cms_pages)) {
                        $this->deadEnd();
                    }
                    elseif ($controller && $controller == 'product' && Tools::getValue('id_product') && in_array(Tools::getValue('id_product'), $products)) {
                        $this->deadEnd();
                    }
                    elseif ($controller && $controller == 'category' && Tools::getValue('id_category') && $restricted_url <= 0) {
                        $cur_category = new Category((int)Tools::getValue('id_category'));
                        $parents = $cur_category->getParentsCategories($this->context->language->id);
                        foreach ($parents as $parent) {
                            if (in_array($parent['id_category'], $restricted_cat) || in_array(Tools::getValue('id_category'), $restricted_cat)) {
                                $this->deadEnd();
                            }
                        }
                    }
                    elseif ($restricted_url > 0) {
                        $this->deadEnd();
                    }
                }
            }
        }
    }
    
    /*
    * module: privateshop
    * date: 2019-09-24 20:15:05
    * version: 1.6.0
    */
    protected function passwordRecovery()
    {
        $persist = 0;
        if (Tools::getValue('private_pass_recovery')) {
            if (!($email = trim(Tools::getValue('email'))) || !Validate::isEmail($email)) {
                $this->errors[] = Tools::displayError('Invalid email address.');
                $persist = true;
                self::privateLogin($persist);
            } else {
                $customer = new Customer();
                $customer->getByemail($email);
                if (!Validate::isLoadedObject($customer)) {
                    $this->errors[] = Tools::displayError('There is no account registered for this email address.');
                    $persist = true;
                    self::privateLogin($persist);
                } elseif (!$customer->active) {
                    $this->errors[] = Tools::displayError('You cannot regenerate the password for this account.');
                    $persist = true;
                    self::privateLogin($persist);
                } elseif ((strtotime($customer->last_passwd_gen.'+'.($min_time = (int)Configuration::get('PS_PASSWD_TIME_FRONT')).' minutes') - time()) > 0) {
                    $this->errors[] = sprintf(Tools::displayError('You can regenerate your password only every %d minute(s)'), (int)$min_time);
                    $persist = true;
                    self::privateLogin($persist);
                } else {
                    if (Tools::version_compare(_PS_VERSION_, '1.7.0.0', '>=') == true) {
                        if (!$customer->hasRecentResetPasswordToken()) {
                            $customer->stampResetPasswordToken();
                            $customer->update();
                        }
                        $pass_reset_link = $this->context->link->getPageLink('password', true, null, 'token='.$customer->secure_key.'&id_customer='.(int)$customer->id).'&reset_token='.$customer->reset_password_token;
                    } else {
                        $pass_reset_link = $this->context->link->getPageLink('password', true, null, 'token='.$customer->secure_key.'&id_customer='.(int)$customer->id.'&persist=1');
                    }
                    $mail_params = array(
                        '{email}' => $customer->email,
                        '{lastname}' => $customer->lastname,
                        '{firstname}' => $customer->firstname,
                        '{url}' => $pass_reset_link
                    );
                    if (Mail::Send($this->context->language->id, 'password_query', Mail::l('Password query confirmation'),
                        $mail_params, $customer->email, $customer->firstname.' '.$customer->lastname,null, null, null, null, _PS_MAIL_DIR_, false, $this->context->shop->id)) {
                        $this->context->smarty->assign(array('confirmation' => 2, 'customer_email' => $customer->email));
                        $persist = true;
                        self::privateLogin($persist);
                    }
                    else {
                        $this->errors[] = Tools::displayError('An error occurred while sending the email.');
                        $persist = true;
                        self::privateLogin($persist);
                    }
                }
            }
        } elseif (($token = Tools::getValue('token')) && ($id_customer = (int)Tools::getValue('id_customer'))) {
            $email = Db::getInstance()->getValue('SELECT `email`
                FROM '._DB_PREFIX_.'customer c
                WHERE c.`secure_key` = \''.pSQL($token).'\' AND c.id_customer = '.(int)$id_customer);
            if ($email) {
                $customer = new Customer();
                $customer->getByemail($email);
                if (!Validate::isLoadedObject($customer)) {
                    $this->errors[] = Tools::displayError('Customer account not found');
                    self::privateLogin();
                } elseif (!$customer->active) {
                    $this->errors[] = Tools::displayError('You cannot regenerate the password for this account.');
                    self::privateLogin();
                } elseif ((strtotime($customer->last_passwd_gen.'+'.(int)Configuration::get('PS_PASSWD_TIME_FRONT').' minutes') - time()) > 0){
                    Tools::redirect('index.php?controller=authentication&error_regen_pwd');
                } else {
                    $customer->passwd = Tools::encrypt($password = Tools::passwdGen(MIN_PASSWD_LENGTH));
                    $customer->last_passwd_gen = date('Y-m-d H:i:s', time());
                    if ($customer->update()) {
                        Hook::exec('actionPasswordRenew', array('customer' => $customer, 'password' => $password));
                        $mail_params = array(
                            '{email}' => $customer->email,
                            '{lastname}' => $customer->lastname,
                            '{firstname}' => $customer->firstname,
                            '{passwd}' => $password
                        );
                        if (Mail::Send($this->context->language->id, 'password', Mail::l('Your new password'), $mail_params, $customer->email, $customer->firstname.' '.$customer->lastname, null, null, null, null, _PS_MAIL_DIR_, false, $this->context->shop->id)) {
                            $this->context->smarty->assign(array('confirmation' => 1, 'customer_email' => $customer->email));
                        } else {
                            $this->errors[] = Tools::displayError('An error occurred while sending the email.');
                            self::privateLogin();
                        }
                    } else {
                        $this->errors[] = Tools::displayError('An error occurred with your account, which prevents us from sending you a new password. Please report this issue using the contact form.');
                        self::privateLogin();
                    }
                }
            } else {
                $this->errors[] = Tools::displayError('We cannot regenerate your password with the data you\'ve submitted.');
                self::privateLogin();
            }
        } elseif (Tools::getValue('token') || Tools::getValue('id_customer')) {
            $this->errors[] = Tools::displayError('We cannot regenerate your password with the data you\'ve submitted.');
            self::privateLogin();
        }
    }
    
    /*
    * module: privateshop
    * date: 2019-09-24 20:15:05
    * version: 1.6.0
    */
    private function sendConfirmationMail(Customer $customer)
    {
        if ($customer->is_guest || !Configuration::get('PS_CUSTOMER_CREATION_EMAIL')) {
            return true;
        }
        return Mail::Send(
            $this->context->language->id,
            'account',
            $this->translator->trans(
                'Welcome!',
                array(),
                'Emails.Subject'
            ),
            array(
                '{firstname}' => $customer->firstname,
                '{lastname}' => $customer->lastname,
                '{email}' => $customer->email,
            ),
            $customer->email,
            $customer->firstname.' '.$customer->lastname,
            null,
            null,
            null,
            null,
            _PS_MAIL_DIR_,
            false,
            $this->context->shop->id
        );
    }
    /*
    * module: privateshop
    * date: 2019-09-24 20:15:05
    * version: 1.6.0
    */
    private function getFriendlyModRoute($uri)
    {
        $id_lang = Context::getContext()->language->id;
        $id_shop = Context::getContext()->shop->id;
        if (empty($uri)) {
            return false;
        } else {
            return Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('SELECT a.`page` 
            FROM '._DB_PREFIX_.'meta a
            LEFT JOIN '._DB_PREFIX_.'meta_lang b ON (a.`id_meta` = b.`id_meta`)
            WHERE a.`page` LIKE "%module%"
            AND b.`url_rewrite` = "'.pSQL($uri).'"
            AND b.`id_lang` = '.(int)$id_lang.' AND b.`id_shop` = '.(int)$id_shop);
        }
    }
    
    /*
    * module: privateshop
    * date: 2019-09-24 20:15:05
    * version: 1.6.0
    */
    protected function assignDate()
    {
        $selectedYears = (int)(Tools::getValue('years', 0));
        $years = Tools::dateYears();
        $selectedMonths = (int)(Tools::getValue('months', 0));
        $months = Tools::dateMonths();
        $selectedDays = (int)(Tools::getValue('days', 0));
        $days = Tools::dateDays();
        $this->context->smarty->assign(array(
            'years' => $years,
            'sl_year' => $selectedYears,
            'months' => $months,
            'sl_month' => $selectedMonths,
            'days' => $days,
            'sl_day' => $selectedDays
        ));
    }
    
    /*
    * module: privateshop
    * date: 2019-09-24 20:15:05
    * version: 1.6.0
    */
    protected function checkIfWhitelistedUrl($url)
    {
        $url_check = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT *
            FROM '._DB_PREFIX_.'privateshop_urls
            WHERE `url` = "'.pSQL($url).'"');
        if (empty($url_check)) {
            return false;
        }
        else {
            return true;
        }
    }
    
    /*
    * module: privateshop
    * date: 2019-09-24 20:15:05
    * version: 1.6.0
    */
    protected function checkIfBlacklistedUrl($url)
    {
        $url_check = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT *
            FROM '._DB_PREFIX_.'privateshop_urls_restricted
            WHERE `url` = "'.pSQL($url).'"');
        if (empty($url_check)) {
            return false;
        }
        else {
            return true;
        }
    }
    
    /*
    * module: privateshop
    * date: 2019-09-24 20:15:05
    * version: 1.6.0
    */
    protected function getCustomerQualification($id_customer)
    {
		$groups = Customer::getGroupsStatic($id_customer);
        $permitted = Configuration::get('PRIVATE_CUSTOMERS_GROUPS');
        if (empty($permitted)) {
            return false;
        }
        else {
            $permitted = explode(',', $permitted);
            $result = array_intersect($groups, $permitted);
            if (is_array($result) && !empty($result)) {
                return true;
            }
        }
        return false;
	}
}
