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
*  @license   Copyrights FME Modules
*  @category  FMM Modules
*  @package   PrivateShop
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

if (!defined('_MYSQL_ENGINE_')) {
    define('_MYSQL_ENGINE_', 'MyISAM');
}

class PrivateShop extends Module
{
    public $translations = array();
    
    public function __construct()
    {
        $this->name = 'privateshop';
        $this->tab = 'administration';
        $this->version = '1.6.0';
        $this->author = 'FMM Modules';
        $this->bootstrap = true;
        $this->module_key = '87ab9c57883b99614ee87cacdac232fe';
        $this->author_address = '0xcC5e76A6182fa47eD831E43d80Cd0985a14BB095';

        parent::__construct();

        $this->displayName = $this->l('Private Shop');
        $this->description = $this->l('This module allows you to restrict your online store to accessible by registered customers only.');
        $this->translations = array(
            'email_required' => $this->l('An email address is required.'),
            'passwd_required' => $this->l('Password is required.'),
            'invalid_email' => $this->l('Invalid email address.'),
            'invalid_password' => $this->l('Invalid password.'),
            'required_firstname' => $this->l('First name is required.'),
            'invalid_firstname' => $this->l('First name is invalid.'),
            'required_lastname' => $this->l('Last name is required.'),
            'invalid_lastname' => $this->l('Last name is invalid.'),
            'invalid_birthday' => $this->l('Birth date is invalid.'),
            'account_deactive' => $this->l('Your account isn\'t available at this time, please contact us'),
            'auth_error' => $this->l('Authentication failed.'),
            'guest_account_error' => $this->l('You cannot create a guest account.'),
            'duplicate_email_error' => $this->l('An account using this email address has already been registered.'),
            'phone_error' => $this->l('You must register at least one phone number.'),
            'account_creation_error' => $this->l('An error occurred while creating your account.'),
            'country_error' => $this->l('Country cannot be loaded with address->id_country'),
            'country_deactive' => $this->l('This country is not active.'),
            'zipcode_required' => $this->l('A Zip / Postal code is required.'),
            'invalid_zipcode' => $this->l('The Zip/Postal code you\'ve entered is invalid. It must follow this format: %s'),
            'identificaion_invalid' => $this->l('The identification number is incorrect or has already been used.'),
            'invalid_country' => $this->l('Country is invalid'),
            'state_required' => $this->l('This country requires you to choose a State.'),
            'address_error' => $this->l('An error occurred while creating your address.'),
            'email_sending_error' => $this->l('The email cannot be sent.'),
            'pending_validation' => $this->l('Please have patience. Your Account is pending for validation.'),
            'no_account_registered' => $this->l('There is no account registered for this email address.'),
            'cannot_regen_pwd' => $this->l('You cannot regenerate the password for this account.'),
            'gen_pwd_after_x' => $this->l('You can regenerate your password only every %d minute(s)'),
            'email_sending_error' => $this->l('An error occurred while sending the email.'),
            'account_404' => $this->l('Customer account not found'),
            'pwd_sending_failed' => $this->l('An error occurred with your account, which prevents us from sending you a new password. Please report this issue using the contact form.'),
            'invalid_pwd_data' => $this->l('We cannot regenerate your password with the data you\'ve submitted.'),
            'account_exists' => $this->l('An account using this email address has already been registered. Please enter a valid password or request a new one.'),
        );
    }

    public function install()
    {
        if (!file_exists(_PS_IMG_DIR_.'private')) {
            mkdir(_PS_IMG_DIR_.'private', 0777, true);
        }
        if (!parent::install()
            || !$this->registerHook('backOfficeHeader')
            || !$this->registerHook('header')
            || !$this->registerHook('footer')
            || !$this->registerHook('actionCustomerAccountAdd')
            || !$this->registerHook('ModuleRoutes')
            || !$this->installConfiguration()) {
            return false;
        } else {
            return true;
        }
    }

    public function uninstall()
    {
        if (parent::uninstall()
            && $this->unregisterHook('backOfficeHeader')
            && $this->unregisterHook('header')
            && $this->unregisterHook('footer')
            && $this->uninstallConfiguration()) {
            return true;
        } else {
            return false;
        }
    }

    public function getContent()
    {
        $this->html = $this->display(__FILE__, 'views/templates/hook/info.tpl');
        $this->postProcess();
        return $this->html.$this->displayForm();
    }

    public function getAvailableControllers($by_page_id = false)
    {
        $pages = array();
        $files = Meta::getPages(false);
        if (isset($files) && $files) {
            foreach ($files as $file) {
                $type = (preg_match('#^module-#', $file)) ? 'module' : false;
                if (isset($type) && $type) {
                    $module_pages = explode('-', $file);
                    if (isset($module_pages) && $module_pages) {
                        $module_name = isset($module_pages[1]) && $module_pages[1] ? $module_pages[1] : false;
                        if ($module_name && Validate::isModuleName($module_name) && $module_name != $this->name && Module::isInstalled($module_name)) {
                            if ($by_page_id) {
                                $pages [$file] = $module_pages[2];
                            } else {
                                $pages[$module_name][$file] = $module_pages[2];
                            }
                        }
                    }
                }
            }
        }
        return $pages;
    }

    private function postProcess()
    {
        if (Tools::isSubmit('saveConfiguration')) {
            $languages = Language::getLanguages(false);
            $values = array();
            foreach ($languages as $lang) {
                $values['LOGIN_TITLE'][$lang['id_lang']] = Tools::getValue('LOGIN_TITLE_'.$lang['id_lang']);
                $values['SIGNUP_TITLE'][$lang['id_lang']] = Tools::getValue('SIGNUP_TITLE_'.$lang['id_lang']);
                $values['PRIVATE_RESTRICT_MESSAGE'][$lang['id_lang']] = Tools::getValue('restrict_message_'.$lang['id_lang'], true);
                $values['PRIVATE_CUSTOMER_GROUP_MSG'][$lang['id_lang']] = Tools::getValue('PRIVATE_CUSTOMER_GROUP_MSG_'.$lang['id_lang']);
            }
            //General Configurations
            $form_position = (string)Tools::getValue('FORM_POSITION');
            $private_signup = (int)Tools::getValue('PRIVATE_SIGNUP');
            $background_type = (string)Tools::getValue('BACKGROUND_TYPE');
            $background_color = (string)Tools::getValue('BACKGROUND_COLOR');
            $bg_image = (string)Tools::getValue('bg_image_selected');
            $bg_video_img = (string)Tools::getValue('bg_video_img');
            $custom_logo_img = (string)Tools::getValue('custom_logo_img');

            //Access Control Configurations
            $privatize_shop = (string)Tools::getValue('PRIVATIZE_SHOP');
            $allowed_ip = (string)Tools::getValue('ACCESS_GRANTED_IP');
            $private_products = (Tools::getValue('private_products')) ? implode(',', Tools::getValue('private_products')) : '';
            $category_box = (Tools::getValue('categoryBox')) ? implode(',', Tools::getValue('categoryBox')) : '';
            $cms_pages = (Tools::getValue('cms_pages')) ? implode(',', Tools::getValue('cms_pages')) : '';
            //module-controllers
            $module_pages = Tools::getIsset('MODULE_PAGES') && Tools::getValue('MODULE_PAGES')? implode(',', Tools::getValue('MODULE_PAGES')): '';
            if ($_FILES && $_FILES['bg_image']['name']) {
                $img_real_name = $_FILES['bg_image']['name'];

                if (!file_exists(_PS_MODULE_DIR_.$this->name.'/views/img/private')) {
                    mkdir(_PS_MODULE_DIR_.$this->name.'/views/img/private', 0777, true);
                }
                if (move_uploaded_file($_FILES['bg_image']['tmp_name'], _PS_MODULE_DIR_.$this->name.'/views/img/private/'.(string)$img_real_name)) {
                    $bg_image = $_FILES['bg_image']['name'];
                }
            }
            //Temp img for Youtube vid BG
            if ($_FILES && $_FILES['bg_video_img']['name'] && $background_type == 'background-video') {
                $img_real_name = $_FILES['bg_video_img']['name'];

                if (!file_exists(_PS_MODULE_DIR_.$this->name.'/views/img/private/tmp')) {
                    mkdir(_PS_MODULE_DIR_.$this->name.'/views/img/private/tmp', 0777, true);
                }
                if (move_uploaded_file($_FILES['bg_video_img']['tmp_name'], _PS_MODULE_DIR_.$this->name.'/views/img/private/tmp/'.(string)$img_real_name)) {
                    $bg_video_img = $_FILES['bg_video_img']['name'];
                }
            }
            //logo for custom
            if ($_FILES && $_FILES['custom_logo_img']['name']) {
                $img_real_name = $_FILES['custom_logo_img']['name'];

                if (!file_exists(_PS_MODULE_DIR_.$this->name.'/views/img/private/tmp')) {
                    mkdir(_PS_MODULE_DIR_.$this->name.'/views/img/private/tmp', 0777, true);
                }
                if (move_uploaded_file($_FILES['custom_logo_img']['tmp_name'], _PS_MODULE_DIR_.$this->name.'/views/img/private/tmp/'.(string)$img_real_name)) {
                    $custom_logo_img = $_FILES['custom_logo_img']['name'];
                }
            }

            Configuration::updateValue('MODULE_PAGES', $module_pages);
            Configuration::updateValue('PRIVATIZE_SHOP', $privatize_shop);
            Configuration::updateValue('LOGIN_TITLE', $values['LOGIN_TITLE']);
            Configuration::updateValue('SIGNUP_TITLE', $values['SIGNUP_TITLE']);
            Configuration::updateValue('PRIVATE_RESTRICT_MESSAGE', $values['PRIVATE_RESTRICT_MESSAGE'], true);
            Configuration::updateValue('PRIVATE_CUSTOMER_GROUP_MSG', $values['PRIVATE_CUSTOMER_GROUP_MSG'], true);
            Configuration::updateValue('FORM_POSITION', $form_position);
            Configuration::updateValue('PRIVATE_SIGNUP', $private_signup);
            Configuration::updateValue('BACKGROUND_TYPE', $background_type);
            Configuration::updateValue('BACKGROUND_COLOR', $background_color);
            Configuration::updateValue('bg_image', $bg_image);
            Configuration::updateValue('ACCESS_GRANTED_IP', $allowed_ip);
            Configuration::updateValue('private_products', $private_products);
            Configuration::updateValue('categoryBox', $category_box);
            Configuration::updateValue('cms_pages', $cms_pages);
            Configuration::updateValue('PRIVATE_SIGNUP_RESTRICT', (int)Tools::getValue('PRIVATE_SIGNUP_RESTRICT'));
            Configuration::updateValue('PRIVATE_RESTRICT_GOOGLE', (int)Tools::getValue('PRIVATE_RESTRICT_GOOGLE'));
            Configuration::updateValue('PRIVATE_SHOW_STORE_TITLE', (int)Tools::getValue('PRIVATE_SHOW_STORE_TITLE'));
            Configuration::updateValue('PRIVATE_FORM_THEME', Tools::getValue('PRIVATE_FORM_THEME'));
            Configuration::updateValue('BG_OPACITY', Tools::getValue('BG_OPACITY'));
            Configuration::updateValue('PRIVATE_BDAY', Tools::getValue('PRIVATE_BDAY'));
            Configuration::updateValue('PRIVATE_GENDER_OPT', Tools::getValue('PRIVATE_GENDER_OPT'));
            Configuration::updateValue('PRIVATE_NLETTER_OPT', Tools::getValue('PRIVATE_NLETTER_OPT'));
            Configuration::updateValue('PRIVATE_OFFERS_OPT', Tools::getValue('PRIVATE_OFFERS_OPT'));
            Configuration::updateValue('PRIVATE_CUSTOM_LOGO', Tools::getValue('PRIVATE_CUSTOM_LOGO'));
            Configuration::updateValue('BACKGROUND_VIDEO', Tools::getValue('BACKGROUND_VIDEO'));
            Configuration::updateValue('PRIVATE_CUSTOMER_GROUP_STATE', (int)Tools::getValue('PRIVATE_CUSTOMER_GROUP_STATE'));
            if ($_FILES && $_FILES['bg_video_img']['name'] && $background_type == 'background-video') {
                Configuration::updateValue('BACKGROUND_VIDEO_IMG', $bg_video_img);
            }
            if ($_FILES && $_FILES['custom_logo_img']['name']) {
                Configuration::updateValue('PRIVATE_CUSTOM_LOGO_IMG', $custom_logo_img);
            }
            //Save URLs whitelisted
            $whitelisted_urls = Tools::getValue('whiteurls');
            Db::getInstance()->delete('privateshop_urls');
            if (!empty($whitelisted_urls)) {
                foreach ($whitelisted_urls as $url) {
                    if (!empty($url)) {
                        Db::getInstance()->insert(
                            'privateshop_urls',
                            array(
                                'url' => $url
                            )
                        );
                    }
                }
            }
            //Save URLs restricted
            $restricturls = Tools::getValue('restricturls');
            Db::getInstance()->delete('privateshop_urls_restricted');
            if (!empty($restricturls)) {
                foreach ($restricturls as $url) {
                    if (!empty($url)) {
                        Db::getInstance()->insert(
                            'privateshop_urls_restricted',
                            array(
                                'url' => $url
                            )
                        );
                    }
                }
            }
            //Save Customer Groups
            $groups = Tools::getValue('groups');
            $groups = is_array($groups) ? implode(',', $groups) : '';
            Configuration::updateValue('PRIVATE_CUSTOMERS_GROUPS', $groups);
            // Multishop processing
            if (Shop::isFeatureActive()) {
                $assoc_shops = Tools::getValue('checkBoxShopAsso_privateshop');
                Db::getInstance()->delete('privateshop_shop');
                if (isset($assoc_shops) && $assoc_shops) {
                    foreach ($assoc_shops as $id_shop) {
                        Db::getInstance()->insert(
                            'privateshop_shop',
                            array(
                                'id_shop' => (int)$id_shop,
                                'id_group' => (int)Shop::getGroupFromShop($id_shop)
                            )
                        );
                    }
                }
            }
            Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&conf=4&token='.Tools::getAdminTokenLite('AdminModules'));
        } elseif (Tools::isSubmit('activatecustomer')) {
            $id_customer = (int)Tools::getValue('id_customer');
            if ($id_customer > 0) {
                $customer = new Customer($id_customer);
                if ((int)$customer->active <= 0) {
                    $customer->active = 1;
                    $customer->update();
                    $this->sendMailCustomerAccount($customer);
                }
            }
        } elseif (Tools::isSubmit('search')) {
            $n = ((int)Tools::getValue('n') > 10) ? (int)Tools::getValue('n') : 10;
            $sort = (int)Tools::getValue('filter_select_pos');
            $state = (int)Tools::getValue('filter_select_state');
            $name = Tools::getValue('search_by_name');
            Configuration::updateValue('PRIVATESHOP_FILTER_n', $n);
            Configuration::updateValue('PRIVATESHOP_FILTER_pos', $sort);
            Configuration::updateValue('PRIVATESHOP_FILTER_state', $state);
            Configuration::updateValue('PRIVATESHOP_FILTER_name', $name);
            Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&conf=4&tab_module=customers&token='.Tools::getAdminTokenLite('AdminModules'));
        } elseif (Tools::isSubmit('searchReset')) {
            Configuration::updateValue('PRIVATESHOP_FILTER_n', 10);
            Configuration::updateValue('PRIVATESHOP_FILTER_pos', 0);
            Configuration::updateValue('PRIVATESHOP_FILTER_state', 0);
            Configuration::updateValue('PRIVATESHOP_FILTER_name', '');
            Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&conf=4&tab_module=customers&token='.Tools::getAdminTokenLite('AdminModules'));
        }
    }

    public function installConfiguration()
    {
        Configuration::updateValue('PRIVATIZE_SHOP', 'whole-shop');
        Configuration::updateValue('LOGIN_TITLE', $this->l('Private Login'));
        Configuration::updateValue('SIGNUP_TITLE', $this->l('Private Signup'));
        Configuration::updateValue('FORM_POSITION', 'center');
        Configuration::updateValue('PRIVATE_SIGNUP', 1);
        Configuration::updateValue('PRIVATE_SHOW_STORE_TITLE', 1);
        Configuration::updateValue('BACKGROUND_TYPE', 'background-color');
        Configuration::updateValue('PRIVATE_FORM_THEME', 'mod');
        Configuration::updateValue('BACKGROUND_COLOR', '#0085a9');
        Configuration::updateValue('bg_image', '');
        Configuration::updateValue('ACCESS_GRANTED_IP', '');
        Configuration::updateValue('private_products', '');
        Configuration::updateValue('categoryBox', '');
        Configuration::updateValue('cms_pages', '');
        Configuration::updateValue('PS_JS_DEFER', 0);
        Configuration::updateValue('MODULE_PAGES', '');
        Configuration::updateValue('PRIVATE_CUSTOMERS_GROUPS', '3');
        Configuration::updateValue('PRIVATE_CUSTOMER_GROUP_STATE', 0);
        $this->createTable();
        return true;
    }

    public function uninstallConfiguration()
    {
        Configuration::deleteByName('PRIVATIZE_SHOP');
        Configuration::deleteByName('LOGIN_TITLE');
        Configuration::deleteByName('SIGNUP_TITLE');
        Configuration::deleteByName('FORM_POSITION');
        Configuration::deleteByName('PRIVATE_SIGNUP');
        Configuration::deleteByName('BACKGROUND_TYPE');
        Configuration::deleteByName('BACKGROUND_COLOR');
        Configuration::deleteByName('bg_image');
        Configuration::deleteByName('ACCESS_GRANTED_IP');
        Configuration::deleteByName('private_products');
        Configuration::deleteByName('categoryBox');
        Configuration::deleteByName('cms_pages');
        Configuration::deleteByName('MODULE_PAGES');
        Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'privateshop_shop`');
        Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'privateshop_urls`');
        Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'privateshop_urls_restricted`');
        return true;
    }

    public function getConfigurationValues()
    {
        $languages = Language::getLanguages(false);
        $fields = array();
        foreach ($languages as $lang) {
            $fields['login_title'][$lang['id_lang']] = Tools::getValue('LOGIN_TITLE_'.$lang['id_lang'], Configuration::get('LOGIN_TITLE', $lang['id_lang']));
            $fields['signup_title'][$lang['id_lang']] = Tools::getValue('SIGNUP_TITLE_'.$lang['id_lang'], Configuration::get('SIGNUP_TITLE', $lang['id_lang']));
            $fields['restrict_message'][$lang['id_lang']] = Tools::getValue('restrict_message_'.$lang['id_lang'], Configuration::get('PRIVATE_RESTRICT_MESSAGE', $lang['id_lang']));
            $fields['cg_mesg'][$lang['id_lang']] = Tools::getValue('PRIVATE_CUSTOMER_GROUP_MSG_'.$lang['id_lang'], Configuration::get('PRIVATE_CUSTOMER_GROUP_MSG', $lang['id_lang']));
        }
        $theme = (empty(Configuration::get('PRIVATE_FORM_THEME'))) ? 'mod' : Configuration::get('PRIVATE_FORM_THEME');
        $conf_values = array(
            'PRIVATIZE_SHOP' => Configuration::get('PRIVATIZE_SHOP'),
            'login_title' => $fields['login_title'],
            'signup_title' => $fields['signup_title'],
            'restrict_message' => $fields['restrict_message'],
            'cg_mesg' => $fields['cg_mesg'],
            'position' => Configuration::get('FORM_POSITION'),
            'active_signup' => Configuration::get('PRIVATE_SIGNUP'),
            'bg_type' => Configuration::get('BACKGROUND_TYPE'),
            'bg_color' => Configuration::get('BACKGROUND_COLOR'),
            'bg_video' => Configuration::get('BACKGROUND_VIDEO'),
            'bg_video_img' => Configuration::get('BACKGROUND_VIDEO_IMG'),
            'bg_img' => Configuration::get('bg_image'),
            'allowed_ip' => Configuration::get('ACCESS_GRANTED_IP'),
            'products' => Configuration::get('private_products'),
            'category' => Configuration::get('categoryBox'),
            'pages' => Configuration::get('cms_pages'),
            'groups' => Configuration::get('PRIVATE_CUSTOMERS_GROUPS'),
            'bg_opacity' => Configuration::get('BG_OPACITY'),
            'bday' => Configuration::get('PRIVATE_BDAY'),
            'custom_logo_img' => Configuration::get('PRIVATE_CUSTOM_LOGO_IMG'),
            'nletter_opt' => Configuration::get('PRIVATE_NLETTER_OPT'),
            'offers_opt' => Configuration::get('PRIVATE_OFFERS_OPT'),
            'gender_opt' => Configuration::get('PRIVATE_GENDER_OPT'),
            'custom_logo' => Configuration::get('PRIVATE_CUSTOM_LOGO'),
            'active_signup_restrict' => (int)Configuration::get('PRIVATE_SIGNUP_RESTRICT'),
            'active_google' => (int)Configuration::get('PRIVATE_RESTRICT_GOOGLE'),
            'cgroup_active' => (int)Configuration::get('PRIVATE_CUSTOMER_GROUP_STATE'),
            'priv_form_theme' => $theme,
            'show_store_title' => (int)Configuration::get('PRIVATE_SHOW_STORE_TITLE'));
        return $conf_values;
    }
    
    public function displayForm()
    {
        $field_values = $this->getConfigurationValues();
        $module_pages = $this->getAvailableControllers();
        $white_list_urls = $this->getAllWhitelistUrls();
        $restrict_urls = $this->getAllRestrictedUrls();;
        $token = Tools::getAdminTokenLite('AdminModules');
        $module_link = $this->context->link->getAdminLink('AdminModules', false);
        $url = $module_link.'&configure=privateshop&token='.$token.'&tab_module=administration&module_name=privateshop';
        $category_tree = '';
        $root = Category::getRootCategory();
        $customers = $this->getAllCustomers();
        $customer_groups = Group::getGroups($this->context->language->id);
        foreach ($customer_groups as $key => $group) {
            if ($group['id_group'] <= 2) {
                unset($customer_groups[$key]);
            }
        }
        $languages = Language::getLanguages(false);
        if (Tools::version_compare(_PS_VERSION_, '1.6.0.0', '>=')) {
            $tree = new HelperTreeCategories('associated-categories-tree', $this->l('Associated categories'));
            $tree->setRootCategory($root->id);
            $tree->setUseCheckBox(true);
            $tree->setUseSearch(true);
            if (isset($field_values) && !empty($field_values['category'])) {
                $selected_categories = explode(',', $field_values['category']);
                $tree->setSelectedCategories($selected_categories);
            }

            $category_tree = $tree->render();
        } else {
            $tree = new Helper();
            $category_tree = $tree->renderCategoryTree(null,
                (isset($field_values) && !empty($field_values['category']) ?  explode(',', $field_values['category']) : array()),
                'categoryBox[]',
                true,
                true,
                array(),
                false,
                false);
        }

        $products = '';
        if (isset($field_values) && !empty($field_values['products'])) {
            $products = explode(',', $field_values['products']);
        }
        $pages = '';
        if (isset($field_values) && !empty($field_values['pages'])) {
            $pages = explode(',', $field_values['pages']);
        }
        $selected_groups = '';
        if (isset($field_values) && !empty($field_values['groups'])) {
            $selected_groups = explode(',', $field_values['groups']);
        }
        $module_controllers = Configuration::get('MODULE_PAGES') && !empty(Configuration::get('MODULE_PAGES'))? explode(',', Configuration::get('MODULE_PAGES')) : array();
        $shops = '';
        $selected_shops = '';
        $multishop = 0;
        if (Shop::isFeatureActive()) {
            $multishop = 1;
            $shops = $this->renderShops();
            $selected_shops = ($this->getAssocShops())? implode(',', $this->getAssocShops()) :'';
        }
        $this->context->smarty->assign(array('shops' => $shops, 'selected_shops' => $selected_shops));
        $iso_tiny_mce = $this->context->language->iso_code;
        $iso_tiny_mce = (file_exists(_PS_JS_DIR_.'tiny_mce/langs/'.$iso_tiny_mce.'.js') ? $iso_tiny_mce : 'en');
        $this->context->controller->addJS(array(
            _PS_JS_DIR_.'tiny_mce/tiny_mce.js',
            _PS_JS_DIR_.'admin/tinymce.inc.js'
            )
        );
        $activate_customer = (int)Tools::getValue('activatecustomer');
        $tab_select = (empty(Tools::getValue('tab_module'))) ? 'administration' : Tools::getValue('tab_module');
        $search = array(
            'n' => (int)Configuration::get('PRIVATESHOP_FILTER_n'),
            'pos' => (int)Configuration::get('PRIVATESHOP_FILTER_pos'),
            'state' => (int)Configuration::get('PRIVATESHOP_FILTER_state'),
            'name' => Configuration::get('PRIVATESHOP_FILTER_name')
        );
        $this->context->smarty->assign(array(
            'version' =>  _PS_VERSION_,
            'URL' => $url,
            'module' => new PrivateShop,
            'multishop' => $multishop,
            'categories' => $category_tree,
            'cms_pages' => CMS::getLinks((int)$this->context->language->id),
            'link' => $this->context->link,
            'admin_dir' => _PS_ADMIN_DIR_,
            'cur_ip' => Tools::getRemoteAddr(),
            'customers' => $customers,
            'ctoken' => Tools::getAdminTokenLite('AdminCustomers'),
            'cIndex' => $this->context->link->getAdminLink('AdminCustomers'),
            'field_values' => $field_values,
            'products' => $products,
            'pages' => $pages,
            'search_link' => $this->context->link->getModuleLink($this->name, 'Privatesearch'),
            'images' => $this->readImageDir(),
            'languages' => $languages,
            'active_lang' => (int)$this->context->language->id,
            'version' => _PS_VERSION_,
            'ad' => __PS_BASE_URI__.basename(_PS_ADMIN_DIR_),
            'iso_tiny_mce' => $iso_tiny_mce,
            'activate_customer' => $activate_customer,
            'tab_select' => $tab_select,
            'module_pages' => $module_pages,
            'module_controllers' => $module_controllers,
            'activate_index' => AdminController::$currentIndex.'&configure='.$this->name.'&token='.$token.'&tab_module=customers&activatecustomer=1&',
            'search_result' => $search,
            'whitelist_urls' => $white_list_urls,
            'restrict_urls' => $restrict_urls,
            'groups' => $customer_groups,
            'selected_groups' => $selected_groups
        ));
        return $this->display(__FILE__, 'views/templates/admin/form.tpl');
    }

    private function renderShops()
    {
        $this->fields_form = array(
            'form' => array(
                'id_form' => 'field_shops',
                'input' => array(
                    array(
                        'type' => 'shop',
                        'label' => $this->l('Shop association:'),
                        'name' => 'checkBoxShopAsso',
                    ),
                )
            )
        );
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = 'privateshop';
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->id = (int)$this->context->employee->id;
        $helper->identifier = 'id_group';
        $helper->tpl_vars = array_merge(array(
            //'fields_value' => $fields_value,
            'languages' => Language::getLanguages(),
            'id_language' => $this->context->language->id
        ));
        return $helper->renderAssoShop();
    }

    protected function readImageDir()
    {
        $dir = _PS_MODULE_DIR_.'privateshop/views/img/private';
        // Open a known directory, and proceed to read its contents
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                $images = array();
                while (($file = readdir($dh)) !== false) {
                    if (!is_dir($dir.$file) && $file != '.' && $file !== '..' && $file !== 'tmp') {
                        $images[] = $file;
                    }
                }
                closedir($dh);
                return $images;
            }
        }
    }

    public function getAllCustomers()
    {
        $like = '';
        $search_n = ((int)Configuration::get('PRIVATESHOP_FILTER_n') <= 0) ? 10 : (int)Configuration::get('PRIVATESHOP_FILTER_n');
        $search_pos = (int)Configuration::get('PRIVATESHOP_FILTER_pos');
        $search_pos = ($search_pos <= 0) ? ' ORDER BY c.id_customer ASC ' : 'ORDER BY c.id_customer DESC ';
        $search_state = (int)Configuration::get('PRIVATESHOP_FILTER_state');
        $name = Configuration::get('PRIVATESHOP_FILTER_name');
        if (empty($name)) {
            $like = '';
        } elseif (!empty($name) && ($search_state == 1 || $search_state == 2)) {
            $like = 'AND c.firstname LIKE "%'.$name.'%" OR c.lastname LIKE "%'.$name.'%" ';
        } elseif (!empty($name) && $search_state <= 0) {
            $like = 'WHERE c.firstname LIKE "%'.$name.'%" OR c.lastname LIKE "%'.$name.'%" ';
        }

        if ($search_state <= 0) {
            $search_state = '';
        } elseif ($search_state == 1) {
            $search_state = 'WHERE c.active = 1 ';
        } elseif ($search_state == 2) {
            $search_state = 'WHERE c.active = 0 ';
        }
        $sql = 'SELECT c.*, CONCAT(LEFT(c.`firstname`, 1), \'. \', c.`lastname`) `customer`, gl.`name` AS `title`,
            (SELECT co.`date_add` FROM '._DB_PREFIX_.'guest g
                LEFT JOIN '._DB_PREFIX_.'connections co ON co.id_guest = g.id_guest
                WHERE g.id_customer = c.id_customer
                ORDER BY c.date_add DESC
                LIMIT 1
                ) as connect
            FROM '._DB_PREFIX_.'customer c
            LEFT JOIN '._DB_PREFIX_.'gender_lang gl ON (c.id_gender = gl.id_gender AND gl.id_lang = '.(int)$this->context->language->id.')
            '.$search_state.$like.$search_pos.'LIMIT '.(int)$search_n;

        if (Db::getInstance()->executeS($sql)) {
            return Db::getInstance()->executeS($sql);
        } else {
            return false;
        }
    }

    protected function createTable()
    {
        Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'privateshop_shop`(
            `id_shop`           int(10) unsigned NOT NULL,
            `id_group`          int(10) unsigned NOT NULL,
            PRIMARY KEY         (`id_shop`, `id_group`))
            ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8'
        );
        Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'privateshop_urls`(
            `id_privateshop_urls` int(11) NOT NULL auto_increment,
            `url` varchar(255) NOT NULL,
            PRIMARY KEY (`id_privateshop_urls`))
            ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8'
        );
        Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'privateshop_urls_restricted`(
            `id_privateshop_urls_restricted` int(11) NOT NULL auto_increment,
            `url` varchar(255) NOT NULL,
            PRIMARY KEY (`id_privateshop_urls_restricted`))
            ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8'
        );
        return true;
    }

    public static function getAssocShops()
    {
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT id_shop FROM '._DB_PREFIX_.'privateshop_shop');
        $final = array();
        if (isset($result)) {
            foreach ($result as $res) {
                $final[] = $res['id_shop'];
            }
        }
        return $final;
    }
    
    public static function getAllWhitelistUrls()
    {
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT * FROM '._DB_PREFIX_.'privateshop_urls');
    }
    
    public static function getAllRestrictedUrls()
    {
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT * FROM '._DB_PREFIX_.'privateshop_urls_restricted');
    }
    
    public function hookActionCustomerAccountAdd($params)
    {
        $restrict_state = (int)Configuration::get('PRIVATE_SIGNUP_RESTRICT');
        if ($restrict_state > 0) {
            $new_customer = $params['newCustomer'];
            $new_customer->active = 0;
            $new_customer->update();
            //Send email
            $this->sendMailsUserPending($new_customer);
            $this->context->controller->errors[] = $this->translations['pending_validation'];
            $this->context->cookie->logout();
        }
    }
    
    public function hookModuleRoutes()
    {
        return array(
            'module-privateshop-restricted' => array(
                'controller' => 'restricted',
                'rule' => 'restricted',
                'keywords' => array(),
                'params' => array(
                    'fc' => 'module',
                    'module' => 'privateshop',
                ),
            ),
            'module-privateshop-thejax' => array(
                'controller' => 'thejax',
                'rule' => 'private',
                'keywords' => array(),
                'params' => array(
                    'fc' => 'module',
                    'module' => 'privateshop',
                ),
            ),
            'module-privateshop-Privatesearch' => array(
                'controller' => 'Privatesearch',
                'rule' => 'pSearch',
                'keywords' => array(),
                'params' => array(
                    'fc' => 'module',
                    'module' => 'privateshop',
                ),
            ),
        );
    }
    
    private function sendMailsUserPending($customer) {
        //Send email to pending customer
        $module = new PrivateShop;
        $id_lang = (int)$this->context->language->id;
        $employee = new Employee(1);
        $admin_email = Configuration::get('PS_SHOP_EMAIL');
        $admin_email = (empty($admin_email)) ? $employee->email : $admin_email;
        $module->l('Account Pending Validation');
        $template_pending_customer = 'messageforpendingcustomer';
        $template_pending_customer_bo = 'messageforpendingcustomeradmin';
        $heading_pending_customer = Translate::getModuleTranslation('privateshop', 'Account Pending Validation', 'privateshop');
        Mail::Send(
            (int)$id_lang,
            $template_pending_customer,
            $heading_pending_customer,
            array('{name}' => $customer->firstname.' '.$customer->lastname),
            $customer->email,
            null,
            null,
            null,
            null,
            null,
            _PS_MODULE_DIR_.'privateshop/mails/',
            false,
            (int)$this->context->shop->id
        );
        //Send email to store Administrator
        Mail::Send(
            (int)$id_lang,
            $template_pending_customer_bo,
            $heading_pending_customer,
            array('{name}' => $customer->firstname.' '.$customer->lastname, '{email}' => $customer->email, '{id}' => $customer->id),
            $admin_email,
            null,
            null,
            null,
            null,
            null,
            _PS_MODULE_DIR_.'privateshop/mails/',
            false,
            (int)$this->context->shop->id
        );
    }
    
    private function sendMailCustomerAccount($customer) {
        //Send email to approved customer
        $module = new PrivateShop;
        $id_lang = (int)$this->context->language->id;
        $module->l('Account Approved');
        $template_pending_customer = 'messageforaccountactive';
        $heading_pending_customer = Translate::getModuleTranslation('privateshop', 'Account Approved', 'privateshop');
        $link_account = $this->context->link->getPageLink('my-account', true);
        Mail::Send(
            (int)$id_lang,
            $template_pending_customer,
            $heading_pending_customer,
            array('{name}' => $customer->firstname.' '.$customer->lastname, '{email}' => $customer->email, '{account}' => $link_account),
            $customer->email,
            null,
            null,
            null,
            null,
            null,
            _PS_MODULE_DIR_.'privateshop/mails/',
            false,
            (int)$this->context->shop->id
        );
    }
}
