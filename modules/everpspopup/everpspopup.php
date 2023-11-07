<?php
/**
 * Project : everpspopup
 * @author Team Ever
 * @copyright Team Ever
 * @license   Tous droits réservés / Le droit d'auteur s'applique (All rights reserved / French copyright law applies)
 * @link https://www.team-ever.com
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once _PS_MODULE_DIR_.'everpspopup/models/EverPsPopupClass.php';

class Everpspopup extends Module
{
    private $html;
    private $postErrors = array();
    private $postSuccess = array();
    const IMG_FOLDER  = _PS_MODULE_DIR_.'everpspopup/views/img/';
    const POPUP_IMG  = _PS_MODULE_DIR_.'everpspopup/views/img/';
    const POPUP_VIEWS  = _PS_MODULE_DIR_.'everpspopup/views/';

    public function __construct()
    {
        $this->name = 'everpspopup';
        $this->tab = 'administration';
        $this->version = '3.2.2';
        $this->author = 'Team Ever';
        $this->need_instance = 0;
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = $this->l('Ever Popup');
        $this->description = $this->l('No doubt the most famous pop up module');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->isSeven = Tools::version_compare(_PS_VERSION_, '1.7', '>=') ? true : false;
        $this->module_key = '8d700b79019fbaa898182703610023f9';
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        include(dirname(__FILE__).'/sql/install.php');
        Configuration::updateValue('EVERPSPOPUP_FANCYBOX', true);
        Configuration::updateValue('EVERPSPOPUP_AGE', '18');

        if (!$this->isSeven) {
            return parent::install()
                && $this->registerHook('header')
                && $this->registerHook('footer')
                && $this->installModuleTab('AdminEverPsPopup', 'Ever Popup');
        } else {
            return parent::install()
                && $this->registerHook('displayBeforeBodyClosingTag')
                && $this->registerHook('header')
                && $this->installModuleTab('AdminEverPsPopup', 'Ever Popup');
        }
    }

    public function uninstall()
    {
        include(dirname(__FILE__).'/sql/uninstall.php');
        return parent::uninstall()
            && $this->uninstallModuleTab('AdminEverPsPopup');
    }

    /**
     * The installModuleTab method
     *
     * @param string $tabClass
     * @param string $tabName
     * @param integer $idTabParent
     * @return boolean
     */
    private function installModuleTab($tabClass, $tabName)
    {
        $tab = new Tab();
        $tab->class_name = $tabClass;
        $tab->module = $this->name;
        if ($this->isSeven) {
            $tab->id_parent = (int)Tab::getIdFromClassName('AdminParentThemes');
        } else {
            $tab->id_parent = (int)Tab::getIdFromClassName('AdminPreferences');
        }
        foreach (Language::getLanguages(false) as $lang) {
            $tab->name[(int)$lang['id_lang']] = $tabName;
        }
        $tab->position = Tab::getNewLastPosition($tab->id_parent);
        return $tab->save();
    }

    /**
     * The uninstallModuleTab method
     *
     * @param string $tabClass
     * @return boolean
     */
    private function uninstallModuleTab($tabClass)
    {
        $tab = new Tab((int)Tab::getIdFromClassName($tabClass));

        return $tab->delete();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitEverpspopupModule')) == true) {
            $this->postValidation();

            if (!count($this->postErrors)) {
                $this->postProcess();
            }
        }

        // Display errors
        if (count($this->postErrors)) {
            foreach ($this->postErrors as $error) {
                $this->html .= $this->displayError($error);
            }
        }

        // Display confirmations
        if (count($this->postSuccess)) {
            foreach ($this->postSuccess as $success) {
                $this->html .= $this->displayConfirmation($success);
            }
        }
        $this->context->smarty->assign(array(
            'everpspopup_dir' => $this->_path,
        ));

        $this->html .= $this->context->smarty->fetch($this->local_path.'views/templates/admin/header.tpl');
        $this->html .= $this->renderForm();
        $this->html .= $this->context->smarty->fetch($this->local_path.'views/templates/admin/footer.tpl');

        return $this->html;
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitEverpspopupModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Settings'),
                'icon' => 'icon-smile',
                ),
                'input' => array(
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'label' => $this->l('Minimum legal age'),
                        'desc' => $this->l('For adult mode'),
                        'name' => 'EVERPSPOPUP_AGE',
                        'required' => 'true',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable Fancybox'),
                        'desc' => $this->l('Use Fancybox for popups'),
                        'name' => 'EVERPSPOPUP_FANCYBOX',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array(
            'EVERPSPOPUP_AGE' => Configuration::get('EVERPSPOPUP_AGE'),
            'EVERPSPOPUP_FANCYBOX' => Configuration::get('EVERPSPOPUP_FANCYBOX'),
        );
    }

    public function postValidation()
    {
        if (((bool)Tools::isSubmit('submitEverpspopupModule')) == true) {
            if (Tools::getValue('EVERPSPOPUP_AGE')
                && !Validate::isUnsignedInt(Tools::getValue('EVERPSPOPUP_AGE'))
            ) {
                $this->postErrors[] = $this->l(
                    'Error : The field "EVERPSPOPUP_AGE" is not valid'
                );
            }
            if (Tools::getValue('EVERPSPOPUP_FANCYBOX')
                && !Validate::isBool(Tools::getValue('EVERPSPOPUP_FANCYBOX'))
            ) {
                $this->postErrors[] = $this->l(
                    'Error : The field "EVERPSPOPUP_FANCYBOX" is not valid'
                );
            }
        }
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
        $this->postSuccess[] = $this->l('All settings have been saved');
    }

    public function hookHeader()
    {
        $mondialRelay = Module::isInstalled('mondialrelay');
        $controller_name = Tools::getValue('controller');
        // var_dump($this->context->controller);
        if ((int)Configuration::get('EVERPSPOPUP_FANCYBOX')) {
            if ($controller_name != 'order') {
                $this->context->controller->addCSS(($this->_path).'views/css/jquery.fancybox.min.css', 'all');
                $this->context->controller->addJS(($this->_path).'views/js/jquery.fancybox.min.js', 'all');
            }
        }
        $this->context->controller->addCSS(($this->_path).'views/css/everpspopup.css', 'all');
        $this->context->controller->addJS(($this->_path).'views/js/everpspopup.js', 'all');
    }

    public function hookDisplayFooter()
    {
        return $this->hookDisplayBeforeBodyClosingTag();
    }

    /**
    * Hook Prestashop 1.7 only
    */
    public function hookDisplayBeforeBodyClosingTag()
    {
        $controller_name = Tools::getValue('controller');
        $everpopup = new EverPsPopupClass();
        $everpopup = $everpopup->getPopup(
            (int)$this->context->shop->id,
            (int)$this->context->language->id
        );
        // var_dump($everpopup);
        if (!$everpopup || !$everpopup->active) {
            return;
        }
        // Date start & date end
        $now = date('Y-m-d');
        if ($everpopup->date_start !='0000-00-00') {
            if ($everpopup->date_start > $now) {
                $this->smarty->assign(
                    array(
                        'ever_errors' => 'date_start superior to now',
                    )
                );
                return $this->display(__FILE__, 'errors.tpl', $this->getCacheId());
            }
        }
        if ($everpopup->date_end !='0000-00-00') {
            if ($everpopup->date_end < $now) {
                $this->smarty->assign(
                    array(
                        'ever_errors' => 'date_end inferior to now',
                    )
                );
                return $this->display(__FILE__, 'errors.tpl', $this->getCacheId());
            }
        }
        // Only unlogged users
        if ($everpopup->unlogged && (bool)$this->context->customer->isLogged()) {
            $this->smarty->assign(
                array(
                    'ever_errors' => 'only for unlogged',
                )
            );
            return $this->display(__FILE__, 'errors.tpl', $this->getCacheId());
        }
        // Controllers condition
        if ($everpopup->controller_array == 1 && $controller_name != 'cms') {
            $this->smarty->assign(
                array(
                    'ever_errors' => 'only CMS',
                )
            );
            return $this->display(__FILE__, 'errors.tpl', $this->getCacheId());
        } elseif ($everpopup->controller_array == 2 && $controller_name != 'product') {
            $this->smarty->assign(
                array(
                    'ever_errors' => 'only products',
                )
            );
            return $this->display(__FILE__, 'errors.tpl', $this->getCacheId());
        } elseif ($everpopup->controller_array == 3 && $controller_name != 'category') {
            $this->smarty->assign(
                array(
                    'ever_errors' => 'only categories',
                )
            );
            return $this->display(__FILE__, 'errors.tpl', $this->getCacheId());
        } elseif ($everpopup->controller_array == 4 && $controller_name != 'index') {
            $this->smarty->assign(
                array(
                    'ever_errors' => 'only index',
                )
            );
            return $this->display(__FILE__, 'errors.tpl', $this->getCacheId());
        }
        // Allowed categories
        if ($everpopup->controller_array == 3 && $everpopup->categories) {
            $allowed_cats = json_decode(
                $everpopup->categories
            );
            if (!in_array((int)Tools::getValue('id_category'), $allowed_cats)) {
                $this->smarty->assign(
                    array(
                        'ever_errors' => 'category not allowed',
                    )
                );
                return $this->display(__FILE__, 'errors.tpl', $this->getCacheId());
            }
        }
        if ((bool)$this->context->customer->isLogged()) {
            $content = $this->changeShortcodes(
                $everpopup->content,
                (int)$this->context->customer->id
            );
        } else {
            $content = $this->changeShortcodes(
                $everpopup->content,
                false
            );
        }
        // Popup background
        if (file_exists(_PS_MODULE_DIR_.'everpspopup/views/img/everpopup_'.(int)$everpopup->id.'.jpg')) {
            $background = _PS_BASE_URL_.__PS_BASE_URI__.'modules/everpspopup/views/img/everpopup_'.(int)$everpopup->id.'.jpg';
        } else {
            $background = false;
        }
        $this->smarty->assign(
            array(
                'everpspopup' => $everpopup,
                'content' => $content,
                'id_lang' => $this->context->language->id,
                'background' => $background,
            )
        );
        return $this->display(__FILE__, 'everpspopup.tpl', $this->getCacheId());
    }

    private function changeShortcodes($message, $id_entity = false)
    {
        $link = new Link();
        $contactLink = $link->getPageLink('contact');
        if ($id_entity) {
            $entity = new Customer((int)$id_entity);
            $gender = new Gender((int)$entity->id_gender, (int)$entity->id_lang);
            $entityShortcodes = array(
                '[entity_lastname]' => $entity->lastname,
                '[entity_firstname]' => $entity->firstname,
                '[entity_company]' => $entity->company,
                '[entity_siret]' => $entity->siret,
                '[entity_ape]' => $entity->ape,
                '[entity_birthday]' => $entity->birthday,
                '[entity_website]' => $entity->website,
                '[entity_gender]' => $gender->name,
            );
        } else {
            $entityShortcodes = array(
                '[entity_lastname]' => '',
                '[entity_firstname]' => '',
                '[entity_company]' => '',
                '[entity_siret]' => '',
                '[entity_ape]' => '',
                '[entity_birthday]' => '',
                '[entity_website]' => '',
                '[entity_gender]' => '',
            );
        }
        $defaultShortcodes = array(
            '[shop_url]' => Tools::getShopDomainSsl(true),
            '[shop_name]'=> (string)Configuration::get('PS_SHOP_NAME'),
            '[start_cart_link]' => '<a href="'
            .Tools::getShopDomainSsl(true)
            .'/index.php?controller=cart&action=show" rel="nofollow" target="_blank">',
            '[end_cart_link]' => '</a>',
            '[start_shop_link]' => '<a href="'
            .Tools::getShopDomainSsl(true)
            .'" target="_blank">',
            '[start_contact_link]' => '<a href="'.$contactLink.'" rel="nofollow" target="_blank">',
            '[end_shop_link]' => '</a>',
            '[end_contact_link]' => '</a>',
            'NULL' => '', // Useful : remove empty strings in case of NULL
            'null' => '', // Useful : remove empty strings in case of null
            'false' => '', // Useful : remove empty strings in case of false
        );
        $shortcodes = array_merge($entityShortcodes, $defaultShortcodes);
        foreach ($shortcodes as $key => $value) {
            $message = str_replace($key, $value, $message);
        }
        return $message;
    }
}
