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

class PrivateShopOverride extends PrivateShop
{
    public function __construct()
    {
        parent::__construct();

        // $string = preg_replace("/\\\*'/", "\'", 'Private Shop');
        // $strrr = array();
        // $key = md5($string);
        // $kkk = array();
        // $strrr[] = $string;
        // $kkk[] = $key;
        // $arr = array($key => 'Private Shop');

        // $ssss = var_export($arr, true);
        // file_put_contents('file.txt', $ssss);

        // $ssss = var_export($strrr, true);
        // file_put_contents('file.txt', $ssss, FILE_APPEND);

        // $ssss = var_export($kkk, true);
        // file_put_contents('file.txt', $ssss, FILE_APPEND);

        $this->translations['matricule_required'] = $this->l('A matricule number is required.');
        $this->translations['invalid_matricule'] = $this->l('Invalid matricule');
        $this->translations['address_required'] = $this->l('An address is required.');
        $this->translations['invalid_address'] = $this->l('Invalid address.');
        $this->translations['city_required'] = $this->l('A city is required.');
        $this->translations['invalid_city'] = $this->l('Invalid city');
        $this->translations['phone_required'] = $this->l('A phone number is required.');
        $this->translations['invalid_phone'] = $this->l('Invalid phone number');
        $this->translations['address_saving_error'] = $this->l('Could not update your information, please check your data.');
        $this->translations['gcaptcha_error'] = $this->l('Captcha error');
    }

    public function install()
    {
        if (!parent::install()
            || !$this->registerHook('displayGDPRConsentBlock')
            || !$this->registerHook('registerGDPRConsent')
            || !$this->registerHook('actionDeleteGDPRCustomer')
            || !$this->registerHook('actionExportGDPRData')) {
            return false;
        } else {
            return true;
        }
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

    public function hookActionDeleteGDPRCustomer ($customer)
    {

    }

    public function hookActionExportGDPRData ($customer)
    {
        
    }

    public function hookDisplayGDPRConsentBlock($params)
    {
        $this->context->smarty->assign(array(
            'id_module' => $this->id
        ));

        return $this->fetch(_PS_THEME_DIR_ . 'modules/privateshop/views/templates/hook/displayGDPRConsentBlock.tpl');
    }
}
