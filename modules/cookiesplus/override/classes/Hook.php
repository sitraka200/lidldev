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

class Hook extends HookCore
{
    public static function getHookModuleExecList($hook_name = null)
    {
        $modules = parent::getHookModuleExecList($hook_name);

        if (!isset(Context::getContext()->controller->controller_type)
            || (isset(Context::getContext()->controller->controller_type) && Context::getContext()->controller->controller_type != 'admin')) {
            if (Module::isEnabled('cookiesplus')
                && Configuration::get('C_P_ENABLE')
                && (!isset($_COOKIE[Configuration::get('C_P_NAME')])
                || $_COOKIE[Configuration::get('C_P_NAME')] != 'accepted')) {
                include_once(_PS_MODULE_DIR_.'cookiesplus/cookiesplus.php');
                $blockedModulesId = Configuration::get('C_P_MODULES_VALUES') ?
                    Tools::jsonDecode(Configuration::get('C_P_MODULES_VALUES')) : array();

                if (is_array($modules) && is_array($blockedModulesId)) {
                    foreach ($modules as $key => $module) {
                        if (in_array($module['id_module'], $blockedModulesId)) {
                            unset($modules[$key]);
                        }
                    }
                }
                return $modules;
            }
        }

        return $modules;
    }
}
