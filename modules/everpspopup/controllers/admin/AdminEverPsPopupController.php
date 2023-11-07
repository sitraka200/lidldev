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
class AdminEverPsPopupController extends ModuleAdminController
{
    private $html;
    const POPUP_IMG  = _PS_MODULE_DIR_.'everpspopup/views/img/';
    const POPUP_VIEWS  = _PS_MODULE_DIR_.'everpspopup/views/';
    public function __construct()
    {

        $this->bootstrap = true;
        $this->lang = true;
        $this->table = 'everpspopup';
        $this->className = 'EverPsPopupClass';
        $this->context = Context::getContext();
        $this->identifier = "id_everpspopup";
        $this->isSeven = Tools::version_compare(_PS_VERSION_, '1.7', '>=') ? true : false;
        $this->context->smarty->assign(array(
            'everpspopup_dir' => _MODULE_DIR_ . '/everpspopup/'
        ));
        $this->success = array();
        $this->fields_list = array(
            'id_everpspopup' => array(
                'title' => $this->l('ID'),
                'align' => 'left',
                'width' => 'auto'
            ),
            'name' => array(
                'title' => $this->l('Name'),
                'align' => 'left',
                'width' => 'auto'
            ),
            'active' => array(
                'title' => $this->l('Status'),
                'type' => 'bool',
                'active' => 'active',
                'orderby' => false,
                'class' => 'fixed-width-sm'
            )
        );

        $this->colorOnBackground = true;

        parent::__construct();
    }

    protected function l($string, $class = null, $addslashes = false, $htmlentities = true)
    {
        if ($this->isSeven) {
            $module = Module::getInstanceByName('everpspopup');
            return $module->l($string, 'AdminEverPsPopupController');
            // return Context::getContext()->getTranslator()->trans($string);
        }

        return parent::l($string, $class, $addslashes, $htmlentities);
    }
    
    /**
     * Gestion de la toolbar
     */
    public function initPageHeaderToolbar()
    {

        //Bouton d'ajout
        $this->page_header_toolbar_btn['new'] = array(
            'href' => self::$currentIndex . '&add' . $this->table . '&token=' . $this->token,
            'desc' => $this->module->l('Add new element'),
            'icon' => 'process-icon-new'
        );

        parent::initPageHeaderToolbar();
    }

    public function renderList()
    {
        $this->addRowAction('edit');
        $this->addRowAction('delete');
        $this->toolbar_title = $this->l('Popup configuration');

        $this->bulk_actions = array(
            'delete' => array(
                'text' => $this->l('Delete selected items'),
                'confirm' => $this->l('Delete selected items ?')
            ),
        );

        if (Tools::isSubmit('submitBulkdelete'.$this->table)) {
            $this->processBulkDelete();
        }
        if (Tools::isSubmit('submitBulkdisableSelection'.$this->table)) {
            $this->processBulkDisable();
        }
        if (Tools::isSubmit('submitBulkenableSelection'.$this->table)) {
            $this->processBulkEnable();
        }
        if (Tools::getIsset('deleteeverpspopup') && Tools::getValue('id_everpspopup')) {
            $everObj = new EverPsPopupClass((int)Tools::getValue('id_everpspopup'));
            $everObj->delete();
        }
        if (Tools::getIsset('activeeverpspopup') && Tools::getValue('id_everpspopup')) {
            $everObj = new EverPsPopupClass((int)Tools::getValue('id_everpspopup'));
            $everObj->active = !$everObj->active;
            $everObj->save();
        }

        $lists = parent::renderList();

        $this->html .= $this->context->smarty->fetch(self::POPUP_VIEWS.'templates/admin/header.tpl');
        if (count($this->errors)) {
            $this->context->smarty->assign(array(
                'errors' => $this->errors
            ));
            $this->html .= $this->context->smarty->fetch(self::POPUP_VIEWS.'templates/admin/errors.tpl');
        }
        if (count($this->success)) {
            $this->context->smarty->assign(array(
                'success' => $this->success
            ));
            $this->html .= $this->context->smarty->fetch(self::POPUP_VIEWS.'templates/admin/success.tpl');
        }
        $this->html .= $lists;
        $this->html .= $this->context->smarty->fetch(self::POPUP_VIEWS.'templates/admin/footer.tpl');

        return $this->html;
    }

    public function renderForm()
    {
        if (count($this->errors)) {
            return false;
        }
        $id = Tools::getValue('id_everpspopup');
        $everpopup = new EverPsPopupClass($id);
        // Check if bg exists
        if ($id) {
            $selected_cat = json_decode($everpopup->categories);
            if (!is_array($selected_cat)) {
                $selected_cat = array($selected_cat);
            }
            $file = self::POPUP_IMG.'everpopup_'.(int)$id.'.jpg';
            $bg = (file_exists($file) ?
                '<img src="'.__PS_BASE_URI__.'modules/everpspopup/views/img/everpopup_'
                .(int)$id.'.jpg" style="max-width:150px;">' : ''
            );
            $tree = array(
                'selected_categories' => $selected_cat,
                'use_search' => true,
                'use_checkbox' => true,
                'id' => 'id_category_tree',
            );
        } else {
            $bg = '';
            $selected_cat = array();
            $tree = array(
                'selected_categories' => $selected_cat,
                'use_search' => true,
                'use_checkbox' => true,
                'id' => 'id_category_tree',
            );
        }
        // die(var_dump($tree));
        // build conditions array
        $showCondition = array(
            array(
                'id_option' => 1,
                'name' => $this->l('CMS only')
            ),
            array(
                'id_option' => 2,
                'name' => $this->l('Products only')
            ),
            array(
                'id_option' => 3,
                'name' => $this->l('Categories only')
            ),
            array(
                'id_option' => 4,
                'name' => $this->l('Home only')
            ),
            array(
                'id_option' => 5,
                'name' => $this->l('All')
            ),
        );

        // build cookie_time array
        $cookie_time = array(
            array(
              'id_option' => 1,
              'name' => $this->l('1 day')
            ),
            array(
              'id_option' => 2,
              'name' => $this->l('2 days')
            ),
            array(
              'id_option' => 3,
              'name' => $this->l('3 days')
            ),
            array(
              'id_option' => 4,
              'name' => $this->l('4 days')
            ),
            array(
              'id_option' => 5,
              'name' => $this->l('5 days')
            ),
            array(
              'id_option' => 7,
              'name' => $this->l('7 days')
            ),
            array(
              'id_option' => 10,
              'name' => $this->l('10 days')
            ),
            array(
              'id_option' => 15,
              'name' => $this->l('15 days')
            ),
            array(
              'id_option' => 20,
              'name' => $this->l('20 days')
            ),
            array(
              'id_option' => 30,
              'name' => $this->l('30 days')
            ),
            array(
              'id_option' => 60,
              'name' => $this->l('60 days')
            ),
            array(
              'id_option' => 0,
              'name' => $this->l('Disabled')
            )
        );

        // Building the Add/Edit form
        $this->fields_form = array(
            'tinymce' => true,
            'description' => $this->l('Add a new popup'),
            'submit' => array(
                'name' => 'save',
                'title' => $this->l('Save'),
                'class' => 'btn button pull-right'
            ),
            'input' => array(
                array(
                    'type' => 'categories',
                    'name' => 'categories',
                    'label' => $this->l('Category'),
                    'desc' => 'Set popup only in specific categories',
                    'hint' => 'Leave empty for no use',
                    'tree' => $tree,
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Where to show the popup ?'),
                    'desc' => $this->l('Choose default controller for this popup'),
                    'hint' => $this->l('Set "All" for all pages on front-office'),
                    'name' => 'controller_array',
                    'required' => true,
                    'options' => array(
                        'query' => $showCondition,
                        'id' => 'id_option',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Lifetime of the cookie (in days)'),
                    'desc' => $this->l('If disabled, the popup will show systematically'),
                    'hint' => $this->l('Set 0 or disable for debug'),
                    'name' => 'cookie_time',
                    'required' => true,
                    'options' => array(
                        'query' => $cookie_time,
                        'id' => 'id_option',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('For unlogged users'),
                    'desc' => $this->l('Popup only for unlogged users'),
                    'hint' => $this->l('Else will appear for each user'),
                    'name' => 'unlogged',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => true,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => false,
                            'label' => $this->l('Disabled')
                        )
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show newsletter subscription form ?'),
                    'desc' => $this->l('You must have Prestashop newsletter module'),
                    'hint' => $this->l('Form won\'t appear if Prestashop module is not set'),
                    'name' => 'newsletter',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => true,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => false,
                            'label' => $this->l('Disabled')
                        )
                    ),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Name'),
                    'desc' => $this->l('Won\'t appear on front-office'),
                    'hint' => $this->l('Useful and required on back-office'),
                    'required' => true,
                    'name' => 'name',
                    'lang' => true
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Popup content'),
                    'desc' => $this->l('Type popup content'),
                    'hint' => $this->l('Will appear in front-office'),
                    'required' => false,
                    'name' => 'content',
                    'lang' => true,
                    'autoload_rte' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Popup link'),
                    'desc' => $this->l('Will make all popup cliquable'),
                    'hint' => $this->l('Leave empty for no use'),
                    'required' => true,
                    'name' => 'link',
                    'lang' => true
                ),
                array(
                    'type' => 'color',
                    'label' => $this->l('Popup content background color'),
                    'desc' => $this->l('Will change popup content color'),
                    'hint' => $this->l('Not all the popup, only content'),
                    'required' => false,
                    'name' => 'bgcolor',
                ),
                array(
                    'type' => 'file',
                    'label' => $this->l('Popup image background'),
                    'desc' => $this->l('For all popup size, including content'),
                    'hint' => $this->l('Change default CSS on everpspopup.css file'),
                    'name' => 'background',
                    'display_image' => true,
                    'image' => $bg
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Adult mode'),
                    'desc' => $this->l('Set yes for asking user birthday'),
                    'hint' => $this->l('Will block screen'),
                    'name' => 'adult_mode',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => true,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => false,
                            'label' => $this->l('Disabled')
                        )
                    ),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Delay'),
                    'desc' => $this->l('Delay before popup appears'),
                    'hint' => $this->l('Value must be in milliseconds'),
                    'name' => 'delay'
                ),
                array(
                    'type' => 'date',
                    'label' => $this->l('Date start'),
                    'desc' => $this->l('Date popup will start to appear'),
                    'hint' => $this->l('Leave empty for no use'),
                    'name' => 'date_start',
                ),
                array(
                    'type' => 'date',
                    'label' => $this->l('Date end'),
                    'desc' => $this->l('Date popup will end'),
                    'hint' => $this->l('Leave empty for no use'),
                    'name' => 'date_end',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Active'),
                    'desc' => $this->l('Enable popup'),
                    'hint' => $this->l('Set no for not activating this popup'),
                    'name' => 'active',
                    'lang' => false,
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
            )
        );
        $lists = parent::renderForm();

        $this->html .= $this->context->smarty->fetch(
            self::POPUP_VIEWS.'templates/admin/header.tpl'
        );
        $this->html .= $lists;
        if (count($this->errors)) {
            foreach ($this->errors as $error) {
                $this->html .= Tools::displayError($error);
            }
        }
        $this->html .= $this->context->smarty->fetch(
            self::POPUP_VIEWS.'templates/admin/footer.tpl'
        );

        return $this->html;
    }

    public function postProcess()
    {
        if ($this->isSeven) {
            $ps_newsletter = Module::isInstalled('ps_emailsubscription');
        } else {
            $ps_newsletter = Module::isInstalled('blocknewsletter');
        }

        if (Tools::isSubmit('save')) {
            if (Tools::getValue('unlogged')
                && !Validate::isBool(Tools::getValue('unlogged'))
            ) {
                 $this->errors[] = $this->l('Unlogged is not valid');
            }
            if (Tools::getValue('newsletter')
                && !Validate::isBool(Tools::getValue('newsletter'))
            ) {
                 $this->errors[] = $this->l('Newsletter is not valid');
            }
            if (Tools::getValue('newsletter')
                && !$ps_newsletter
            ) {
                 $this->errors[] = $this->l('Newsletter module is not installed');
            }
            if (Tools::getValue('bgcolor')
                && !Validate::isColor(Tools::getValue('bgcolor'))
            ) {
                 $this->errors[] = $this->l('Color is not valid');
            }
            if (Tools::getValue('controller_array')
                && !Validate::isJson(json_encode(Tools::getValue('controller_array')))
            ) {
                 $this->errors[] = $this->l('Controller is not valid');
            }
            if (Tools::getValue('controller_array')
                && !Validate::isunsignedInt(Tools::getValue('controller_array'))
            ) {
                 $this->errors[] = $this->l('Controller is not valid');
            }
            if (Tools::getValue('categories')
                && !Validate::isArrayWithIds(Tools::getValue('categories'))
            ) {
                 $this->errors[] = $this->l('Controller is not valid');
            }
            if (Tools::getValue('cookie_time')
                && !Validate::isunsignedInt(Tools::getValue('cookie_time'))
            ) {
                 $this->errors[] = $this->l('Cookie time is not valid');
            }
            if (Tools::getValue('adult_mode')
                && !Validate::isBool(Tools::getValue('adult_mode'))
            ) {
                 $this->errors[] = $this->l('Adult mode is not valid');
            }
            if (Tools::getValue('delay')
                && !Validate::isunsignedInt(Tools::getValue('delay'))
            ) {
                 $this->errors[] = $this->l('Delay is not valid');
            }
            if (Tools::getValue('date_start')
                && !Validate::isDateFormat(Tools::getValue('date_start'))
            ) {
                 $this->errors[] = $this->l('Date start is not valid');
            }
            if (Tools::getValue('date_end')
                && !Validate::isDateFormat(Tools::getValue('date_end'))
            ) {
                 $this->errors[] = $this->l('Date end is not valid');
            }
            if (Tools::getValue('active')
                && !Validate::isBool(Tools::getValue('active'))
            ) {
                 $this->errors[] = $this->l('Active is not valid');
            }

            if (Tools::getValue('id_everpspopup')) {
                $everpopup = new EverPsPopupClass(
                    (int)Tools::getValue('id_everpspopup')
                );
            } else {
                $everpopup = new EverPsPopupClass();
            }
            $everpopup->id_shop = (int)$this->context->shop->id;
            $everpopup->unlogged = (int)Tools::getValue('unlogged');
            $everpopup->newsletter = (int)Tools::getValue('newsletter');
            $everpopup->bgcolor = Tools::getValue('bgcolor');
            $everpopup->controller_array = (int)Tools::getValue('controller_array');
            $everpopup->categories = json_encode(Tools::getValue('categories'));
            $everpopup->cookie_time = (int)Tools::getValue('cookie_time');
            $everpopup->delay = (int)Tools::getValue('delay');
            $everpopup->date_start = Tools::getValue('date_start');
            $everpopup->date_end = Tools::getValue('date_end');
            $everpopup->adult_mode = (int)Tools::getValue('adult_mode');
            $everpopup->active = (int)Tools::getValue('active');
            foreach (Language::getLanguages(false) as $language) {
                if (!Tools::getIsset('name_'.$language['id_lang'])
                    || !Validate::isGenericName(Tools::getValue('name_'.$language['id_lang']))
                ) {
                    $this->errors[] = $this->l('Name is not valid for lang ').$language['id_lang'];
                } else {
                    $everpopup->name[$language['id_lang']] = Tools::getValue('name_'.$language['id_lang']);
                }
                if (Tools::getValue('content_'.$language['id_lang'])
                    && !Validate::isCleanHtml(Tools::getValue('content_'.$language['id_lang']))
                ) {
                    $this->errors[] = $this->l('Content is not valid for lang ').$language['id_lang'];
                } else {
                    $everpopup->content[$language['id_lang']] = Tools::getValue('content_'.$language['id_lang']);
                }
                if (!Tools::getIsset('link_'.$language['id_lang'])
                    && !Validate::isUrl(Tools::getValue('link_'.$language['id_lang']))
                ) {
                    $this->errors[] = $this->l('Link is not valid for lang ').$language['id_lang'];
                } else {
                    $everpopup->link[$language['id_lang']] = Tools::getValue('link_'.$language['id_lang']);
                }
            }

            if (!count($this->errors)) {
                if ($everpopup->save()) {
                    /* upload the image */
                    if (isset($_FILES['background'])
                        && isset($_FILES['background']['tmp_name'])
                        && !empty($_FILES['background']['tmp_name'])
                    ) {
                        Configuration::set('PS_IMAGE_GENERATION_METHOD', 1);
                        if (file_exists(self::POPUP_IMG.'/everpopup_'.(int)$everpopup->id.'.jpg')) {
                            unlink(self::POPUP_IMG.'everpopup_'.(int)$everpopup->id.'.jpg');
                        }
                        if ($error = ImageManager::validateUpload($_FILES['background'])) {
                            $this->errors[] = $error;
                        } elseif (!($tmp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS'))
                            || !move_uploaded_file($_FILES['background']['tmp_name'], $tmp_name)
                        ) {
                            return false;
                        } elseif (!ImageManager::resize(
                            $tmp_name,
                            self::POPUP_IMG.'everpopup_'.(int)$everpopup->id.'.jpg'
                        )) {
                            $this->errors[] = $this->l('An error occurred while attempting to upload the image.');
                        }
                        if (isset($tmp_name)) {
                            unlink($tmp_name);
                        }
                    }
                    $this->success[] = $this->l('Popup has been fully saved');
                    Tools::clearSmartyCache();
                } else {
                    $this->errors[] = $this->l('Can\'t update the current object');
                }
            }
        }
    }

    protected function processBulkDelete()
    {
        foreach (Tools::getValue($this->table.'Box') as $idEverBlock) {
            $everpopup = new EverPsPopupClass((int)$idEverBlock);

            if (!$everpopup->delete()) {
                $this->errors[] = $this->l('An error has occurred: Can\'t delete the current object');
            } else {
                $this->errors[] = $this->l('Objects has been fully deleted');
            }
        }
    }

    protected function processBulkDisable()
    {
        foreach (Tools::getValue($this->table.'Box') as $idEverBlock) {
            $everpopup = new EverPsPopupClass((int)$idEverBlock);
            if ($everpopup->active) {
                $everpopup->active = false;
            }

            if (!$everpopup->save()) {
                $this->errors[] = $this->l('An error has occurred: Can\'t delete the current object');
            } else {
                $this->html .= $this->l('Objects has been fully disabled');
            }
        }
    }

    protected function processBulkEnable()
    {
        foreach (Tools::getValue($this->table.'Box') as $idEverBlock) {
            $everpopup = new EverPsPopupClass((int)$idEverBlock);
            if (!$everpopup->active) {
                $everpopup->active = true;
            }

            if (!$everpopup->save()) {
                $this->errors[] = $this->l('An error has occurred: Can\'t delete the current object');
            } else {
                $this->errors[] = $this->l('Objects has been fully enabled');
            }
        }
    }
}
