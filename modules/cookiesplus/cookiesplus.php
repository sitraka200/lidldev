<?php
/**
* Cookies Plus
*
* NOTICE OF LICENSE
*
* This product is licensed for one customer to use on one installation (test stores and multishop included).
* Site developer has the right to modify this module to suit their needs, but can not redistribute the module in
* whole or in part. Any other use of this module constitues a violation of the user agreement.
*
* DISCLAIMER
*
* NO WARRANTIES OF DATA SAFETY OR MODULE SECURITY
* ARE EXPRESSED OR IMPLIED. USE THIS MODULE IN ACCORDANCE
* WITH YOUR MERCHANT AGREEMENT, KNOWING THAT VIOLATIONS OF
* PCI COMPLIANCY OR A DATA BREACH CAN COST THOUSANDS OF DOLLARS
* IN FINES AND DAMAGE A STORES REPUTATION. USE AT YOUR OWN RISK.
*
*  @author    idnovate.com <info@idnovate.com>
*  @copyright 2017 idnovate.com
*  @license   See above
*/

class CookiesPlus extends Module
{
    public function __construct()
    {
        $this->name = 'cookiesplus';
        $this->tab = 'front_office_features';
        $this->version = '1.0.8';
        $this->author = 'idnovate';
        $this->module_key = '22c3b977fe9c819543a216a2fd948f22';
        $this->bootstrap = true;
        $this->ps_versions_compliancy = array('min' => '1.4', 'max' => _PS_VERSION_);

        parent::__construct();

        $this->displayName = $this->l('Cookies Plus - EU Cookie law (notification + block)');
        $this->description = $this->l('Comply with the EU cookie law using this module');
        $this->confirmUninstall = $this->l('Are you sure you want to delete the module and the related data?');

        /* Backward compatibility */
        if (version_compare(_PS_VERSION_, '1.5', '<')) {
            require(_PS_MODULE_DIR_.$this->name.'/backward_compatibility/backward.php');
            $this->local_path = _PS_MODULE_DIR_.$this->name.'/';
        }

        if (version_compare(_PS_VERSION_, '1.6', '>=')) {
            if (Configuration::get('PS_DISABLE_NON_NATIVE_MODULE')) {
                $this->warning =
                    $this->l('You have to enable non PrestaShop modules at "ADVANCED PARAMETERS - PERFORMANCE"');
            }
        }
    }

    public function install()
    {
        if (!parent::install()
            || !$this->registerHook('header')
            || !Configuration::updateValue('C_P_NAME', 'psnotice')
            || !Configuration::updateValue('C_P_EXPIRY', '365')
            || !Configuration::updateValue('C_P_MODE', '1')
            || !Configuration::updateValue('C_P_NOTICE_FIXED', '1')
            || !Configuration::updateValue('C_P_ACCEPT_BUTTON', '1')
            || !Configuration::updateValue('C_P_DECLINE_BUTTON', '1')
            || !Configuration::updateValue('C_P_NOTICE_TEXT_CL', '#eeeeee')
            || !Configuration::updateValue('C_P_NOTICE_BG_CL', '#111111')
            || !Configuration::updateValue('C_P_NOTICE_BG_OPACITY', '0.9')
            || !Configuration::updateValue('C_P_ACCEPT_BUTTON_TEXT_CL', '#FFFFFF')
            || !Configuration::updateValue('C_P_ACCEPT_BUTTON_BG_CL', '#007700')
            || !Configuration::updateValue('C_P_ACCEPT_BUTTON_BG_HOVER_CL', '#009900')
            || !Configuration::updateValue('C_P_DECLINE_BUTTON_TEXT_CL', '#FFFFFF')
            || !Configuration::updateValue('C_P_DECLINE_BUTTON_BG_CL', '#990000')
            || !Configuration::updateValue('C_P_DECLINE_BUTTON_BG_HOVER_CL', '#bb0000')
            || !Configuration::updateValue('C_P_POLICY_BUTTON_TEXT_CL', '#FFFFFF')
            || !Configuration::updateValue('C_P_POLICY_BUTTON_BG_CL', '#0033BB')
            || !Configuration::updateValue('C_P_POLICY_BUTTON_BG_HOVER_CL', '#0055DD')
            ) {
            return false;
        }

        $fields = array();

        //Initialize multilang configuration values
        $translations = array();
        $translations['C_P_TEXT']['en'] = 'We use cookies to ensure that we give you the best experience on our website. If you continue browsing, we\'ll assume that you are happy to receive all cookies from this website.';
        $translations['C_P_TEXT']['es'] = 'Usamos cookies para poderte ofrecer la mejor experiencia en nuestra web. Si continuas navegando, damos por hecho que aceptas que guardemos las cookies para este sitio.';

        $translations['C_P_ACCEPT_BUTTON_TEXT']['en'] = 'Accept';
        $translations['C_P_ACCEPT_BUTTON_TEXT']['es'] = 'Aceptar';

        $translations['C_P_DECLINE_BUTTON_TEXT']['en'] = 'Decline';
        $translations['C_P_DECLINE_BUTTON_TEXT']['es'] = 'Rechazar';

        $translations['C_P_POLICY_BUTTON_TEXT']['en'] = 'More info';
        $translations['C_P_POLICY_BUTTON_TEXT']['es'] = 'Más información';

        $languages = Language::getLanguages(false);

        foreach ($languages as $lang) {
            $fields['C_P_TEXT'][$lang['id_lang']] = isset($translations['C_P_TEXT'][$lang['iso_code']]) ? $translations['C_P_TEXT'][$lang['iso_code']] : $translations['C_P_TEXT']['en'];
            $fields['C_P_ACCEPT_BUTTON_TEXT'][$lang['id_lang']] = isset($translations['C_P_ACCEPT_BUTTON_TEXT'][$lang['iso_code']]) ? $translations['C_P_ACCEPT_BUTTON_TEXT'][$lang['iso_code']] : $translations['C_P_ACCEPT_BUTTON_TEXT']['en'];
            $fields['C_P_DECLINE_BUTTON_TEXT'][$lang['id_lang']] = isset($translations['C_P_DECLINE_BUTTON_TEXT'][$lang['iso_code']]) ? $translations['C_P_DECLINE_BUTTON_TEXT'][$lang['iso_code']] : $translations['C_P_DECLINE_BUTTON_TEXT']['en'];
            $fields['C_P_POLICY_BUTTON_TEXT'][$lang['id_lang']] = isset($translations['C_P_POLICY_BUTTON_TEXT'][$lang['iso_code']]) ? $translations['C_P_POLICY_BUTTON_TEXT'][$lang['iso_code']] : $translations['C_P_POLICY_BUTTON_TEXT']['en'];
        }

        if (!Configuration::updateValue('C_P_TEXT', $fields['C_P_TEXT'], true)
            || !Configuration::updateValue(
                'C_P_ACCEPT_BUTTON_TEXT',
                $fields['C_P_ACCEPT_BUTTON_TEXT']
            )
            || !Configuration::updateValue(
                'C_P_DECLINE_BUTTON_TEXT',
                $fields['C_P_DECLINE_BUTTON_TEXT']
            )
            || !Configuration::updateValue(
                'C_P_POLICY_BUTTON_TEXT',
                $fields['C_P_POLICY_BUTTON_TEXT']
            )
        ) {
            return false;
        }

        return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall()) {
            return false;
        }

        $fields = array_merge($this->getConfigValues(), $this->getLangConfigValues());

        foreach (array_keys($fields) as $key) {
            Configuration::deleteByName($key);
        }

        return true;
    }

    public function getContent()
    {
        $html = '';
        if (((bool)Tools::isSubmit('submitCookiesPlusModule')) == true) {
            $html .= $this->postProcess();
        }

        if (version_compare(_PS_VERSION_, '1.5', '<')) {
            return $html . $this->renderForm14();
        } else {
            return $html . $this->renderForm();
        }
    }

    protected function renderForm()
    {
        $html = '';

        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitCookiesPlusModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        $html .= $helper->generateForm($this->getConfigForm());

        if (version_compare(_PS_VERSION_, '1.6', '>=')) {
            $this->context->smarty->assign(array(
                'this_path'     => $this->_path,
                'support_id'    => '21644'
            ));

            $available_iso_codes = array('en', 'es');
            $default_iso_code = 'en';
            $template_iso_suffix = in_array($this->context->language->iso_code, $available_iso_codes) ? $this->context->language->iso_code : $default_iso_code;
            $html .= $this->context->smarty->fetch($this->local_path.'views/templates/admin/company/information_'.$template_iso_suffix.'.tpl');
        }

        return $html;
    }

    protected function renderForm14()
    {
        $helper = new Helper();

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(),
            'languages' => Language::getLanguages(false),
            'id_language' => $this->context->language->id,
            'THEME_LANG_DIR' => _PS_IMG_.'l/'
        );

        return $helper->generateForm($this->getConfigForm());
    }

    protected function getConfigForm()
    {
        $fields = array();

        $fields[]['form'] = array(
            'legend' => array(
                'title' => $this->l('Module settings'),
                'icon' => 'icon-cogs',
            ),
            'input' => array(
                array(
                    'type' => (version_compare(_PS_VERSION_, '1.6', '>=')) ? 'switch' : 'radio',
                    'label' => $this->l('Enable module'),
                    'desc'  => $this->l(''),
                    'name' => 'C_P_ENABLE',
                    'class' => 't',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'C_P_ENABLE_on',
                            'value' => 1,
                            'label' => $this->l('Yes')),
                        array(
                            'id' => 'C_P_ENABLE_off',
                            'value' => 0,
                            'label' => $this->l('No')),
                    ),
                ),
                array(
                    'col' => 3,
                    'type' => 'text',
                    'label' => $this->l('Cookie name'),
                    'name' => 'C_P_NAME',
                    'class' => 't',
                    'required' => true,
                ),
                array(
                    'type' => 'radio',
                    'label' => $this->l('Mode'),
                    'name' => 'C_P_MODE',
                    'class' => 't',
                    'br' => true,
                    'values' => array(
                        array(
                            'id' => 'C_P_MODE_1',
                            'value' => 1,
                            'label' => $this->l('Classic mode: display notice but don\'t block cookies')
                        ),
                        array(
                            'id' => 'C_P_MODE_2',
                            'value' => 2,
                            'label' =>
                                $this->l('Restrictive mode: display notice and block cookies until cookies are accepted')
                        ),
                    ),
                ),
                array(
                    'type' => (version_compare(_PS_VERSION_, '1.6', '>=')) ? 'switch' : 'radio',
                    'label' => $this->l('Accept cookie when visitor moves to another page'),
                    'desc'  => $this->l(''),
                    'name' => 'C_P_ACCEPT_MOVE',
                    'is_bool' => true,
                    'class' => 't',
                    'values' => array(
                        array(
                            'id' => 'C_P_ACCEPT_MOVE_on',
                            'value' => 1,
                            'label' => $this->l('Yes')),
                        array(
                            'id' => 'C_P_ACCEPT_MOVE_off',
                            'value' => 0,
                            'label' => $this->l('No')),
                    ),
                ),
                array(
                    'type' => (version_compare(_PS_VERSION_, '1.6', '>=')) ? 'switch' : 'radio',
                    'label' => $this->l('Accept cookie when visitor scrolls up or down'),
                    'desc'  => $this->l(''),
                    'name' => 'C_P_ACCEPT_SCROLL',
                    'is_bool' => true,
                    'class' => 't',
                    'values' => array(
                        array(
                            'id' => 'C_P_ACCEPT_SCROLL_on',
                            'value' => 1,
                            'label' => $this->l('Yes')),
                        array(
                            'id' => 'C_P_ACCEPT_SCROLL_off',
                            'value' => 0,
                            'label' => $this->l('No')),
                    ),
                ),
                array(
                    'type' => (version_compare(_PS_VERSION_, '1.6', '>=')) ? 'switch' : 'radio',
                    'label' => $this->l('Accept cookie when visitor clicks anywhere on the page'),
                    'desc'  => $this->l(''),
                    'name' => 'C_P_ACCEPT_CLICK',
                    'is_bool' => true,
                    'class' => 't',
                    'values' => array(
                        array(
                            'id' => 'C_P_ACCEPT_CLICK_on',
                            'value' => 1,
                            'label' => $this->l('Yes')),
                        array(
                            'id' => 'C_P_ACCEPT_CLICK_off',
                            'value' => 0,
                            'label' => $this->l('No')),
                    ),
                ),
                array(
                    'type' => (version_compare(_PS_VERSION_, '1.6', '>=')) ? 'switch' : 'radio',
                    'label' => $this->l('Accept cookie after X seconds'),
                    'desc'  => $this->l(''),
                    'name' => 'C_P_ACCEPT_TIMEOUT',
                    'is_bool' => true,
                    'class' => 't',
                    'values' => array(
                        array(
                            'id' => 'C_P_ACCEPT_TIMEOUT_on',
                            'value' => 1,
                            'label' => $this->l('Yes')),
                        array(
                            'id' => 'C_P_ACCEPT_TIMEOUT_off',
                            'value' => 0,
                            'label' => $this->l('No')),
                    ),
                ),
                array(
                    'col' => 2,
                    'type' => 'text',
                    'label' => $this->l('Accept cookie automatically after these seconds'),
                    'suffix' => 'seconds',
                    'name' => 'C_P_ACCEPT_TIMEOUT_S',
                    'class' => 't',
                ),
                array(
                    'col' => 2,
                    'type' => 'text',
                    'label' => $this->l('Cookie lifetime'),
                    'hint' =>
                        $this->l('Cookie consent will be stored during this time (or until customer delete cookies)'),
                    'suffix' => 'days',
                    'name' => 'C_P_EXPIRY',
                    'class' => 't',
                    'required' => true,
                ),
            ),
            'submit' => array(
                'title' => $this->l('Update settings'),
                'type' => 'submit',
                'name' => 'submitCookiesPlusModule',
            ),
        );

        $fields[]['form'] = array(
            'legend' => array(
                'title' => $this->l('Module appearance'),
                'icon' => 'icon-cogs',
            ),
            'input' => array(
                /*array(
                    'type' => 'select',
                    'label' => $this->l('Notice style'),
                    'name' => 'C_P_NOTICE_STYLE',
                    'options' => array(
                        'query' => array(
                            array(
                                'id' => 'classic',
                                'name' => $this->l('Classic')
                            ),
                            array(
                                'id' => 'popup',
                                'name' => $this->l('Popup'),
                            ),
                            array(
                                'id' => 'monster',
                                'name' => $this->l('Cookie monster'),
                            )
                        ),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                ),*/
                array(
                    'type' => 'select',
                    'label' => $this->l('Notice position'),
                    'name' => 'C_P_NOTICE_POSITION',
                    'class' => 't',
                    'options' => array(
                        'query' => array(
                            array(
                                'id' => 1,
                                'name' => $this->l('Top')
                            ),
                            array(
                                'id' => 2,
                                'name' => $this->l('Bottom'),
                            )
                        ),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                ),
                array(
                    'type' => (version_compare(_PS_VERSION_, '1.6', '>=')) ? 'switch' : 'radio',
                    'label' => $this->l('Fixed notice'),
                    'desc'  => $this->l(''),
                    'name' => 'C_P_NOTICE_FIXED',
                    'is_bool' => true,
                    'class' => 't',
                    'values' => array(
                        array(
                            'id' => 'C_P_NOTICE_FIXED_on',
                            'value' => 1,
                            'label' => $this->l('Yes')),
                        array(
                            'id' => 'C_P_NOTICE_FIXED_off',
                            'value' => 0,
                            'label' => $this->l('No')),
                    ),
                    //'desc' => 'aaa',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Effect when hidding notice'),
                    'name' => 'C_P_NOTICE_EFFECT',
                    'class' => 't',
                    'options' => array(
                        'query' => array(
                            array(
                                'id' => 'slide',
                                'name' => $this->l('Slide')
                            ),
                            array(
                                'id' => 'fade',
                                'name' => $this->l('Fade'),
                            ),
                            array(
                                'id' => 'hide',
                                'name' => $this->l('Hide'),
                            )
                        ),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                ),
                array(
                    'cols' => 90,
                    'type' => 'textarea',
                    'label' => $this->l('Cookie notice text'),
                    'name' => 'C_P_TEXT',
                    'lang' => true,
                    'class' => 't',
                    'autoload_rte' => 'rte',
                ),
                array(
                    'type' => 'color',
                    'name' => 'C_P_NOTICE_TEXT_CL',
                    'label' => $this->l('Notice font color'),
                    'class' => 't',
                ),
                array(
                    'type' => 'color',
                    'name' => 'C_P_NOTICE_BG_CL',
                    'label' => $this->l('Notice background color'),
                    'class' => 't',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Notice opacity'),
                    'name' => 'C_P_NOTICE_BG_OPACITY',
                    'class' => 't',
                    'options' => array(
                        'query' => array(
                            array(
                                'id' => '1',
                                'name' => '1'
                            ),
                            array(
                                'id' => '0.9',
                                'name' => '0.9',
                            ),
                            array(
                                'id' => '0.8',
                                'name' => '0.8',
                            ),
                            array(
                                'id' => '0.7',
                                'name' => '0.7',
                            ),
                            array(
                                'id' => '0.6',
                                'name' => '0.6',
                            ),
                            array(
                                'id' => '0.5',
                                'name' => '0.5',
                            ),
                            array(
                                'id' => '0.4',
                                'name' => '0.4',
                            ),
                            array(
                                'id' => '0.3',
                                'name' => '0.3',
                            ),
                            array(
                                'id' => '0.2',
                                'name' => '0.2',
                            ),
                            array(
                                'id' => '0.1',
                                'name' => '0.1',
                            ),
                            array(
                                'id' => '0',
                                'name' => '0',
                            ),
                        ),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                ),
                array(
                    'type' => (version_compare(_PS_VERSION_, '1.6', '>=')) ? 'switch' : 'radio',
                    'label' => $this->l('Display "Accept" button'),
                    'desc'  => $this->l(''),
                    'name' => 'C_P_ACCEPT_BUTTON',
                    'is_bool' => true,
                    'class' => 't',
                    'values' => array(
                        array(
                            'id' => 'C_P_ACCEPT_BUTTON_on',
                            'value' => 1,
                            'label' => $this->l('Yes')),
                        array(
                            'id' => 'C_P_ACCEPT_BUTTON_off',
                            'value' => 0,
                            'label' => $this->l('No')),
                    ),
                ),
                array(
                    'col' => 3,
                    'type' => 'text',
                    'label' => $this->l('"Accept" button text'),
                    'name' => 'C_P_ACCEPT_BUTTON_TEXT',
                    'lang' => true,
                    'class' => 't',
                ),
                array(
                    'type' => 'color',
                    'name' => 'C_P_ACCEPT_BUTTON_TEXT_CL',
                    'label' => $this->l('"Accept" button font color'),
                    'class' => 't',
                ),
                array(
                    'type' => 'color',
                    'name' => 'C_P_ACCEPT_BUTTON_BG_CL',
                    'label' => $this->l('"Accept" button background color'),
                    'class' => 't',
                ),
                array(
                    'type' => 'color',
                    'name' => 'C_P_ACCEPT_BUTTON_BG_HOVER_CL',
                    'label' => $this->l('"Accept" button background hover color'),
                    'class' => 't',
                ),
                array(
                    'type' => (version_compare(_PS_VERSION_, '1.6', '>=')) ? 'switch' : 'radio',
                    'label' => $this->l('Display "Decline" button'),
                    'desc'  => $this->l(''),
                    'name' => 'C_P_DECLINE_BUTTON',
                    'class' => 't',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'C_P_DECLINE_BUTTON_on',
                            'value' => 1,
                            'label' => $this->l('Yes')),
                        array(
                            'id' => 'C_P_DECLINE_BUTTON_off',
                            'value' => 0,
                            'label' => $this->l('No')),
                    ),
                ),
                array(
                    'col' => 3,
                    'type' => 'text',
                    'label' => $this->l('"Decline" button text'),
                    'name' => 'C_P_DECLINE_BUTTON_TEXT',
                    'class' => 't',
                    'lang' => true,
                ),
                array(
                    'type' => 'color',
                    'name' => 'C_P_DECLINE_BUTTON_TEXT_CL',
                    'label' => $this->l('"Decline" button font color'),
                    'class' => 't',
                ),
                array(
                    'type' => 'color',
                    'name' => 'C_P_DECLINE_BUTTON_BG_CL',
                    'label' => $this->l('"Decline" button background color'),
                    'class' => 't',
                ),
                array(
                    'type' => 'color',
                    'name' => 'C_P_DECLINE_BUTTON_BG_HOVER_CL',
                    'label' => $this->l('"Decline" button background hover color'),
                    'class' => 't',
                ),
                array(
                    'col' => 3,
                    'type' => 'text',
                    'label' => $this->l('URL redirect if cookies are declined'),
                    'name' => 'C_P_DECLINE_BUTTON_URL',
                    'class' => 't',
                    'lang' => true,
                ),
                array(
                    'type' => (version_compare(_PS_VERSION_, '1.6', '>=')) ? 'switch' : 'radio',
                    'label' => $this->l('Display "Privacy policy" button'),
                    'desc'  => $this->l(''),
                    'name' => 'C_P_POLICY_BUTTON',
                    'class' => 't',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'C_P_POLICY_BUTTON_on',
                            'value' => 1,
                            'label' => $this->l('Yes')),
                        array(
                            'id' => 'C_P_POLICY_BUTTON_off',
                            'value' => 0,
                            'label' => $this->l('No')),
                    ),
                ),
                array(
                    'col' => 3,
                    'type' => 'text',
                    'label' => $this->l('"Privacy" button text'),
                    'name' => 'C_P_POLICY_BUTTON_TEXT',
                    'class' => 't',
                    'lang' => true,
                ),
                array(
                    'type' => 'color',
                    'name' => 'C_P_POLICY_BUTTON_TEXT_CL',
                    'label' => $this->l('"Privacy" button font color'),
                    'class' => 't',
                ),
                array(
                    'type' => 'color',
                    'name' => 'C_P_POLICY_BUTTON_BG_CL',
                    'label' => $this->l('"Privacy" button background color'),
                    'class' => 't',
                ),
                array(
                    'type' => 'color',
                    'name' => 'C_P_POLICY_BUTTON_BG_HOVER_CL',
                    'label' => $this->l('"Privacy" button background hover color'),
                    'class' => 't',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('CMS page for the Conditions of use'),
                    'name' => 'C_P_CMS_PAGE',
                    'class' => 't',
                    'options' => array(
                        'query' => CMS::listCms($this->context->language->id),
                        'id' => 'id_cms',
                        'name' => 'meta_title'
                    ),
                ),
            ),
            'submit' => array(
                'title' => $this->l('Update settings'),
                'type' => 'submit',
                'name' => 'submitCookiesPlusModule',
            ),
        );

        $fields[]['form'] = array(
            'legend' => array(
                'title' => $this->l('Modules blocked'),
                'icon' => 'icon-cogs',
            ),
            'input' => array(
                array(
                    'col' => 9,
                    'type' => 'free',
                    'label' => $this->l('Modules blocked'),
                    'name' => 'C_P_MODULES',
                    'class' => 't',
                    'lang' => true,
                ),
            ),
            'submit' => array(
                'title' => $this->l('Update settings'),
                'type' => 'submit',
                'name' => 'submitCookiesPlusModule',
            ),
        );

        return $fields;
    }

    protected function getConfigFormValues()
    {
        $fields = array_merge($this->getConfigValues(), $this->getLangConfigValues());

        return $fields;
    }

    protected function postProcess()
    {
        $html = '';
        $errors = array();

        if (!Tools::getValue('C_P_NAME')) {
            $errors[] = $this->l('You have to introduce the cookie name');
        } elseif (!Validate::isHookName(Tools::getValue('C_P_EXPIRY'))) {
            $errors[] = $this->l('You have to introduce a correct value for the cookie name');
        }

        if (!Tools::getValue('C_P_EXPIRY')) {
            $errors[] = $this->l('You have to introduce the cookie expiry time');
        } elseif (!Validate::isUnsignedInt(Tools::getValue('C_P_EXPIRY'))
            || Tools::getValue('C_P_EXPIRY') <= 0) {
            $errors[] = $this->l('You have to introduce a correct value for cookie expiry time');
        }

        if (Tools::getValue('C_P_ACCEPT_TIMEOUT')
            && (!Validate::isUnsignedInt(Tools::getValue('C_P_ACCEPT_TIMEOUT_S'))
                || Tools::getValue('C_P_ACCEPT_TIMEOUT_S') <= 0)) {
            $errors[] = $this->l('You have to introduce a correct value for accepting cookie after X seconds');
        }

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $html .= $this->displayError($error);
            }
        } else {
            $fields = array_merge($this->getConfigValues(), $this->getLangConfigValues());

            foreach (array_keys($fields) as $key) {
                if ($key == 'C_P_MODULES_VALUES') {
                    Configuration::updateValue($key, Tools::jsonEncode(Tools::getValue('C_P_MODULES_VALUES')));
                } else {
                    Configuration::updateValue($key, $fields[$key], true);
                }
            }

            $html .= $this->displayConfirmation($this->l('Configuration saved successfully.'));
        }

        return $html;
    }

    protected function getLangConfigValues()
    {
        $fields = array();

        $languages = Language::getLanguages(false);
        foreach ($languages as $lang) {
            $fields['C_P_TEXT'][$lang['id_lang']] = Tools::getValue(
                'C_P_TEXT_'.$lang['id_lang'],
                Configuration::get('C_P_TEXT', $lang['id_lang'])
            );
            $fields['C_P_ACCEPT_BUTTON_TEXT'][$lang['id_lang']] = Tools::getValue(
                'C_P_ACCEPT_BUTTON_TEXT_'.$lang['id_lang'],
                Configuration::get('C_P_ACCEPT_BUTTON_TEXT', $lang['id_lang'])
            );
            $fields['C_P_DECLINE_BUTTON_TEXT'][$lang['id_lang']] = Tools::getValue(
                'C_P_DECLINE_BUTTON_TEXT_'.$lang['id_lang'],
                Configuration::get('C_P_DECLINE_BUTTON_TEXT', $lang['id_lang'])
            );
            $fields['C_P_POLICY_BUTTON_TEXT'][$lang['id_lang']] = Tools::getValue(
                'C_P_POLICY_BUTTON_TEXT_'.$lang['id_lang'],
                Configuration::get('C_P_POLICY_BUTTON_TEXT', $lang['id_lang'])
            );
            $fields['C_P_DECLINE_BUTTON_URL'][$lang['id_lang']] = Tools::getValue(
                'C_P_DECLINE_BUTTON_URL_'.$lang['id_lang'],
                Configuration::get('C_P_DECLINE_BUTTON_URL', $lang['id_lang'])
            );
        }

        return $fields;
    }

    protected function getConfigValues()
    {
        $fields = array();

        $fields['C_P_ENABLE'] = Tools::getValue(
            'C_P_ENABLE',
            Configuration::get('C_P_ENABLE')
        );
        $fields['C_P_NAME'] = Tools::getValue('C_P_NAME', Configuration::get('C_P_NAME'));
        $fields['C_P_MODE'] = Tools::getValue('C_P_MODE', Configuration::get('C_P_MODE'));
        $fields['C_P_ACCEPT_MOVE'] = Tools::getValue(
            'C_P_ACCEPT_MOVE',
            Configuration::get('C_P_ACCEPT_MOVE')
        );
        $fields['C_P_ACCEPT_SCROLL'] = Tools::getValue(
            'C_P_ACCEPT_SCROLL',
            Configuration::get('C_P_ACCEPT_SCROLL')
        );
        $fields['C_P_ACCEPT_CLICK'] = Tools::getValue(
            'C_P_ACCEPT_CLICK',
            Configuration::get('C_P_ACCEPT_CLICK')
        );
        $fields['C_P_ACCEPT_TIMEOUT'] = Tools::getValue(
            'C_P_ACCEPT_TIMEOUT',
            Configuration::get('C_P_ACCEPT_TIMEOUT')
        );
        $fields['C_P_ACCEPT_TIMEOUT_S'] = Tools::getValue(
            'C_P_ACCEPT_TIMEOUT_S',
            Configuration::get('C_P_ACCEPT_TIMEOUT_S')
        );
        $fields['C_P_EXPIRY'] = Tools::getValue(
            'C_P_EXPIRY',
            Configuration::get('C_P_EXPIRY')
        );

        $fields['C_P_NOTICE_STYLE'] = Tools::getValue(
            'C_P_NOTICE_STYLE',
            Configuration::get('C_P_NOTICE_STYLE')
        );
        $fields['C_P_NOTICE_TEXT_CL'] = Tools::getValue(
            'C_P_NOTICE_TEXT_CL',
            Configuration::get('C_P_NOTICE_TEXT_CL')
        );
        $fields['C_P_NOTICE_BG_CL'] = Tools::getValue(
            'C_P_NOTICE_BG_CL',
            Configuration::get('C_P_NOTICE_BG_CL')
        );
        $fields['C_P_NOTICE_BG_OPACITY'] = Tools::getValue(
            'C_P_NOTICE_BG_OPACITY',
            Configuration::get('C_P_NOTICE_BG_OPACITY')
        );
        $fields['C_P_NOTICE_POSITION'] = Tools::getValue(
            'C_P_NOTICE_POSITION',
            Configuration::get('C_P_NOTICE_POSITION')
        );
        $fields['C_P_NOTICE_FIXED'] = Tools::getValue(
            'C_P_NOTICE_FIXED',
            Configuration::get('C_P_NOTICE_FIXED')
        );
        $fields['C_P_NOTICE_EFFECT'] = Tools::getValue(
            'C_P_NOTICE_EFFECT',
            Configuration::get('C_P_NOTICE_EFFECT')
        );

        $fields['C_P_ACCEPT_BUTTON'] = Tools::getValue(
            'C_P_ACCEPT_BUTTON',
            Configuration::get('C_P_ACCEPT_BUTTON')
        );
        $fields['C_P_ACCEPT_BUTTON_TEXT_CL'] = Tools::getValue(
            'C_P_ACCEPT_BUTTON_TEXT_CL',
            Configuration::get('C_P_ACCEPT_BUTTON_TEXT_CL')
        );
        $fields['C_P_ACCEPT_BUTTON_BG_CL'] = Tools::getValue(
            'C_P_ACCEPT_BUTTON_BG_CL',
            Configuration::get('C_P_ACCEPT_BUTTON_BG_CL')
        );
        $fields['C_P_ACCEPT_BUTTON_BG_HOVER_CL'] = Tools::getValue(
            'C_P_ACCEPT_BUTTON_BG_HOVER_CL',
            Configuration::get('C_P_ACCEPT_BUTTON_BG_HOVER_CL')
        );
        $fields['C_P_DECLINE_BUTTON'] = Tools::getValue(
            'C_P_DECLINE_BUTTON',
            Configuration::get('C_P_DECLINE_BUTTON')
        );
        $fields['C_P_DECLINE_BUTTON_TEXT_CL'] = Tools::getValue(
            'C_P_DECLINE_BUTTON_TEXT_CL',
            Configuration::get('C_P_DECLINE_BUTTON_TEXT_CL')
        );
        $fields['C_P_DECLINE_BUTTON_BG_CL'] = Tools::getValue(
            'C_P_DECLINE_BUTTON_BG_CL',
            Configuration::get('C_P_DECLINE_BUTTON_BG_CL')
        );
        $fields['C_P_DECLINE_BUTTON_BG_HOVER_CL'] = Tools::getValue(
            'C_P_DECLINE_BUTTON_BG_HOVER_CL',
            Configuration::get('C_P_DECLINE_BUTTON_BG_HOVER_CL')
        );
        $fields['C_P_POLICY_BUTTON'] = Tools::getValue(
            'C_P_POLICY_BUTTON',
            Configuration::get('C_P_POLICY_BUTTON')
        );
        $fields['C_P_POLICY_BUTTON_TEXT_CL'] = Tools::getValue(
            'C_P_POLICY_BUTTON_TEXT_CL',
            Configuration::get('C_P_POLICY_BUTTON_TEXT_CL')
        );
        $fields['C_P_POLICY_BUTTON_BG_CL'] = Tools::getValue(
            'C_P_POLICY_BUTTON_BG_CL',
            Configuration::get('C_P_POLICY_BUTTON_BG_CL')
        );
        $fields['C_P_POLICY_BUTTON_BG_HOVER_CL'] = Tools::getValue(
            'C_P_POLICY_BUTTON_BG_HOVER_CL',
            Configuration::get('C_P_POLICY_BUTTON_BG_HOVER_CL')
        );
        $fields['C_P_CMS_PAGE'] = Tools::getValue(
            'C_P_CMS_PAGE',
            Configuration::get('C_P_CMS_PAGE')
        );
        $fields['C_P_EXPIRY'] = Tools::getValue(
            'C_P_EXPIRY',
            Configuration::get('C_P_EXPIRY')
        );

        $fields['C_P_MODULES_VALUES'] = Configuration::get('C_P_MODULES_VALUES');

        $this->context->smarty->assign('allModules', self::getModuleList());
        $fields['C_P_MODULES'] =
            $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure_modules.tpl');

        return $fields;
    }

    public function hookHeader()
    {
        if (Configuration::get('C_P_ENABLE')) {
            $this->context->controller->addJS($this->_path.'views/js/cookiesplus.cookiebar.js');

            $this->context->smarty->assign(array(
                'CK_mode' => Configuration::get('C_P_MODE'),
                'CK_name' => Configuration::get('C_P_NAME'),
                'CK_exception' => (isset($this->context->controller->cms->id) && $this->context->controller->cms->id == Configuration::get('C_P_CMS_PAGE')) ? 1 : 0,
                'CK_accept_move' => Configuration::get('C_P_ACCEPT_MOVE'),
                'CK_accept_scroll' => Configuration::get('C_P_ACCEPT_SCROLL'),
                'CK_accept_click' => Configuration::get('C_P_ACCEPT_CLICK'),
                'CK_accept_timeout' => Configuration::get('C_P_ACCEPT_TIMEOUT'),
                'CK_accept_timeout_s' => Configuration::get('C_P_ACCEPT_TIMEOUT_S') ?
                    Configuration::get('C_P_ACCEPT_TIMEOUT_S') : 0,
                'CK_message' => Configuration::get('C_P_TEXT', $this->context->cookie->id_lang),
                'CK_accept_button' => Configuration::get('C_P_ACCEPT_BUTTON'),
                'CK_accept_button_text' => Configuration::get(
                    'C_P_ACCEPT_BUTTON_TEXT',
                    $this->context->cookie->id_lang
                ),
                'CK_accept_button_text_color' => Configuration::get('C_P_ACCEPT_BUTTON_TEXT_CL'),
                'CK_accept_button_bg_color' => Configuration::get('C_P_ACCEPT_BUTTON_BG_CL'),
                'CK_accept_button_bg_hover_color' => Configuration::get('C_P_ACCEPT_BUTTON_BG_HOVER_CL'),
                'CK_decline_button' => Configuration::get('C_P_DECLINE_BUTTON'),
                'CK_decline_button_text' => Configuration::get(
                    'C_P_DECLINE_BUTTON_TEXT',
                    $this->context->cookie->id_lang
                ),
                'CK_decline_button_text_color' => Configuration::get('C_P_DECLINE_BUTTON_TEXT_CL'),
                'CK_decline_button_bg_color' => Configuration::get('C_P_DECLINE_BUTTON_BG_CL'),
                'CK_decline_button_bg_hover_color' => Configuration::get('C_P_DECLINE_BUTTON_BG_HOVER_CL'),
                'CK_decline_button_url' => Configuration::get(
                    'C_P_DECLINE_BUTTON_URL',
                    $this->context->cookie->id_lang
                ),
                'CK_policy_button' => Configuration::get('C_P_POLICY_BUTTON'),
                'CK_policy_button_text_color' => Configuration::get('C_P_POLICY_BUTTON_TEXT_CL'),
                'CK_policy_button_bg_color' => Configuration::get('C_P_POLICY_BUTTON_BG_CL'),
                'CK_policy_button_bg_hover_color' => Configuration::get('C_P_POLICY_BUTTON_BG_HOVER_CL'),
                'CK_policy_button_text' => Configuration::get(
                    'C_P_POLICY_BUTTON_TEXT',
                    $this->context->cookie->id_lang
                ),
                'CK_cms_page' => $this->context->link->getCMSLink(Configuration::get('C_P_CMS_PAGE')),
                'CK_cookie_expiry' => Configuration::get('C_P_EXPIRY'),
                'CK_notice_position' => Configuration::get('C_P_NOTICE_POSITION') == 1 ? 0 : 1,
                'CK_notice_fixed' => Configuration::get('C_P_NOTICE_FIXED'),
                'CK_notice_text_color' => Configuration::get('C_P_NOTICE_TEXT_CL'),
                'CK_notice_bg_color' => Configuration::get('C_P_NOTICE_BG_CL'),
                'CK_notice_bg_opacity' => Configuration::get('C_P_NOTICE_BG_OPACITY'),
                'CK_notice_effect' => Configuration::get('C_P_NOTICE_EFFECT'),
                'CK_notice_fixed_bottom' => (Configuration::get('C_P_NOTICE_POSITION') == 2
                    && Configuration::get('C_P_NOTICE_FIXED')) ? 1 : 0,
            ));

            if (version_compare(_PS_VERSION_, '1.5', '<')) {
                return $this->display(__FILE__, '/views/templates/hook/header.tpl');
            } else {
                return $this->display(__FILE__, 'header.tpl');
            }
        }
    }

    public function hookBackOfficeHeader()
    {
        if (Tools::getValue('configure') == $this->name) {
            $this->context->controller->addJS($this->_path.'views/js/cookiesplus.cookiebar.admin.js');
        }
    }

    public static function getModuleList($onlyChecked = false)
    {
        $modules =  Module::getModulesOnDisk();
        foreach ($modules as $key => $module) {
            if ($module->id == 0) {
                unset($modules[$key]);
            }

            $modules_blocked = Configuration::get('C_P_MODULES_VALUES') ?
                Tools::jsonDecode(Configuration::get('C_P_MODULES_VALUES')) : array();

            if ($modules_blocked) {
                if (in_array($module->id, $modules_blocked)) {
                    $module->checked = true;
                } elseif ($onlyChecked) {
                    unset($modules[$key]);
                }
            }
        }

        return $modules;
    }
}
