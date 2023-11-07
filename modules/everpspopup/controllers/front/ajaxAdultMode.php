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

class EverpspopupAjaxAdultModeModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        $this->ajax = true;

        parent::initContent();
    }

    /**
     * Ajax Process
     */
    public function displayAjaxCheckAge()
    {
        if (empty(Tools::getValue('ever_birthday')) || !Validate::isDate(Tools::getValue('ever_birthday'))) {
            die(Tools::jsonEncode(array(
                'return' => false,
                'error' => $this->module->l('Birth ever_birthday is empty or is not valid.')
            )));
        }
        //date in mm/dd/yyyy format; or it can be in other formats as well
        $birthDate = Tools::getValue('ever_birthday');
        //explode the date to get month, day and year
        $birthDate = explode("/", $birthDate);
        //get age from date or birthdate
        $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
        ? ((date("Y") - $birthDate[2]) - 1)
        : (date("Y") - $birthDate[2]));

        if ($age >= (int)Configuration::get('EVERPSPOPUP_AGE')) {
            die(Tools::jsonEncode(array(
                'return' => true,
                'message' => $this->module->l('You are allowed to see this content')
            )));
        } else {
            die(Tools::jsonEncode(array(
                'return' => false,
                'error' => $this->module->l('You are not allowed to see this content')
            )));
        }

        die(Tools::jsonEncode(array(
            'return' => false,
            'error' => $this->module->l('Sorry, something went wrong. Please try again later')
        )));
    }
}
