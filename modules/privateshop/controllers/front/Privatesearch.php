<?php
/**
* PrivateShop
*
* Do not edit or add to this file.
* You are not authorized to modify, copy or redistribute this file.
* Permissions are reserved by FME Modules.
*
*  @author    FME Modules
*  @copyright 2017 FME Modules All right reserved
*  @license   FME Modules
*  @category  FMM Modules
*  @package   PrivateShop
*/

class PrivateShopPrivatesearchModuleFrontController extends ModuleFrontController
{
    public $useSSL = false;
    public function __construct()
    {
        $this->context = Context::getContext();
        parent::__construct();
    }

    public function init()
    {
        parent::init();
        if (Tools::usingSecureMode()) {
            $this->useSSL = true;
        }
    }

    public function initContent()
    {
        parent::initContent();
        $query = Tools::replaceAccentedChars(urldecode(Tools::getValue('q')));
        $searchResults = '';
        if (!empty($query) && $query) {
            $searchResults = Search::find((int)(Tools::getValue('id_lang')), $query, 1, 10, 'position', 'desc', true);
        }
        die(Tools::jsonEncode($searchResults));
    }
}
