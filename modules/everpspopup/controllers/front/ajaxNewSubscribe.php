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

class EverpspopupAjaxNewSubscribeModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        $this->isSeven = Tools::version_compare(_PS_VERSION_, '1.7', '>=') ? true : false;
        $this->ajax = true;

        parent::initContent();
    }

    /**
     * Ajax Process
     */
    public function displayAjaxNewSubscribe()
    {
        $ps_activeNewsletter = false;
        if ($this->isSeven) {
            $ps_activeNewsletter = Module::isEnabled('ps_emailsubscription');
        } else {
            $ps_activeNewsletter = Module::isEnabled('blocknewsletter');
        }

        if ($ps_activeNewsletter) {
            if (empty($_SERVER['REMOTE_ADDR']) || !filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP)) {
                die(Tools::jsonEncode(array(
                    'return' => false,
                    'error' => $this->module->l('User ip not found or not valid', 'AjaxNewSubscribe')
                )));
            }

            if (empty(Tools::getValue('ever_email')) || !Validate::isEmail(Tools::getValue('ever_email'))) {
                die(Tools::jsonEncode(array(
                    'return' => false,
                    'error' => $this->module->l('Mail address is empty or is not valid.', 'AjaxNewSubscribe')
                )));
            }

            // Get needed vars
            $user_ip = $_SERVER['REMOTE_ADDR'];
            $user_email = Tools::getValue('ever_email');

            // Check if email address already exists
            if ($this->isSeven) {
                $table_newsletter_name = 'emailsubscription';
                $id_group_shop =(int)Context::getContext()->shop->id_shop_group;
            } else {
                $id_group_shop =(int)Context::getContext()->shop->id_group;
                $table_newsletter_name = 'newsletter';
            }
            $sql = new DbQuery();
            $sql->select('id');
            $sql->from($table_newsletter_name);
            $sql->where("email = '{$user_email}'");

            $subscribed = Db::getInstance()->getValue($sql);

            if ($subscribed) {
                // if user already subscribe, make sure active is true
                $sql = "UPDATE "._DB_PREFIX_."$table_newsletter_name SET active = 1 WHERE email = '{$user_email}'";
                $activate = Db::getInstance()->execute($sql);
                if (!$activate) {
                    die(Tools::jsonEncode(array(
                        'return' => false,
                        'error' => $this->module->l('Error : Can\'t update the newsletter subscription', 'AjaxNewSubscribe')
                    )));
                }

                die(Tools::jsonEncode(array(
                    'return' => true,
                    'message' => $this->module->l('You\'ve already registered to our mailing list', 'AjaxNewSubscribe')
                )));
            }

            // Add new email address to newsletter table
            $newSubscription = Db::getInstance()->insert(
                $table_newsletter_name,
                array(
                    'id_shop' => (int)Context::getContext()->shop->id,
                    'id_shop_group' => (int)$id_group_shop ,
                    'email' => pSQL($user_email),
                    'newsletter_date_add' => (new DateTime)->format('Y-m-d H:i:s'),
                    'ip_registration_newsletter' => pSQL($user_ip),
                    'active' => 1,
                )
            );

            if ($newSubscription) {
                die(Tools::jsonEncode(array(
                    'return' => true,
                    'message' => $this->module->l('Thank you ! Your e-mail has been successfuly registered.', 'AjaxNewSubscribe')
                )));
            }

            die(Tools::jsonEncode(array(
                'return' => false,
                'error' => $this->module->l('Sorry, something went wrong. Please try again later.', 'AjaxNewSubscribe')
            )));
        } else {
            die(Tools::jsonEncode(array(
                'return' => true,
                'message' => $this->module->l('Module Newsletter not activated', 'AjaxNewSubscribe')
            )));
        }
    }
}
