<?php
/**
* 2007-2018 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2018 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

//header('Content-type: text/javascript');
class PrivateShopThejaxModuleFrontController extends ModuleFrontController
{
    public function __construct()
    {
        parent::__construct();
        $this->context = Context::getContext();
    }

    public function initContent()
    {
        parent::initContent();
        $action = (string)Tools::getValue('action');
        $this->ajax = (bool)Tools::getValue('ajax', false);

        if (empty($action) || $action != 'privateLogin') {
            $restrict_message = Configuration::get('PRIVATE_RESTRICT_MESSAGE', (int)$this->context->language->id);
            $result = array(
                'errors' => 0,
                'message' => $restrict_message,
                'html' => '',
                'redirect' => false,
                'redirect_url' => $this->context->link->getPageLink('my-account')
            );
            $this->errors = array();
            Hook::exec('actionBeforeSubmitAccount');
            $passwd = trim(Tools::getValue('password'));
            $email = trim(Tools::getValue('email_account'));
            $firstname = Tools::getValue('firstname');
            $lastname = Tools::getValue('lastname');
            $gender = Tools::getValue('id_gender');
            $birthday = (empty(Tools::getValue('years')) ? '' : (int)Tools::getValue('years') . '-' . (int)Tools::getValue('months') . '-' . (int)Tools::getValue('days'));
            $optin = Tools::getValue('optin');
            $newsletter = Tools::getValue('newsletter');
            $clearTextPassword = $passwd;
            if (empty($email)) {
                $this->errors[] = $this->module->translations['email_required'];
                $result['errors'] = 1;
                $result['html'] = $this->errors;
            } elseif (!Validate::isEmail($email)) {
                $this->errors[] = $this->module->translations['invalid_email'];
                $result['errors'] = 1;
                $result['html'] = $this->errors;
            } elseif (empty($passwd)) {
                $this->errors[] = $this->module->translations['passwd_required'];
                $result['errors'] = 1;
                $result['html'] = $this->errors;
            } elseif (!Validate::isPasswd($passwd)) {
                $this->errors[] = $this->module->translations['invalid_password'];
                $result['errors'] = 1;
                $result['html'] = $this->errors;
            } elseif (empty($firstname)) {
                $this->errors[] = $this->module->translations['required_firstname'];
                $result['errors'] = 1;
                $result['html'] = $this->errors;
            } elseif (!Validate::isName($firstname)) {
                $this->errors[] = $this->module->translations['invalid_firstname'];
                $result['errors'] = 1;
                $result['html'] = $this->errors;
            } elseif (empty($lastname)) {
                $this->errors[] = $this->module->translations['required_lastname'];
                $result['errors'] = 1;
                $result['html'] = $this->errors;
            } elseif (!Validate::isName($lastname)) {
                $this->errors[] = $this->module->translations['invalid_lastname'];
                $result['errors'] = 1;
                $result['html'] = $this->errors;
            } elseif (!Validate::isBirthDate($birthday)) {
                $this->errors[] = $this->module->translations['invalid_birthday'];
                $result['errors'] = 1;
                $result['html'] = $this->errors;
            }
            elseif (!empty($this->errors)) {
                $result['errors'] = 1;
                $result['success'] = false;
                $result['html'] = $this->errors;
            }
            else {
                $customer = new Customer;
                $customer->email = $email;
                $customer->firstname = $firstname;
                $customer->lastname = $lastname;
                $customer->id_gender = $gender;
                $customer->birthday = $birthday;
                $customer->optin = $optin;
                $customer->newsletter = $newsletter;
                if (!$clearTextPassword) {
                    if (!$this->guest_allowed) {
                        $this->errors['password'][] = $this->module->translations['password_required'];
                        return false;
                    }
                    $clearTextPassword = $this->crypto->hash(
                        microtime(),
                        _COOKIE_KEY_
                    );
                    $customer->is_guest = true;
                }

                $customer->passwd = md5(_COOKIE_KEY_ . $clearTextPassword);
                if (Customer::customerExists($customer->email, false, true)) {
                    $this->errors[] = $this->module->translations['duplicate_email_error'];
                    $result['errors'] = 1;
                    $result['html'] = $this->errors;
                } else {
                    $ok = $customer->save();
                    $restrict_state = (int)Configuration::get('PRIVATE_SIGNUP_RESTRICT');
                    if ($ok) {
                        $this->context->updateCustomer($customer);
                        $this->context->cart->update();
                        if ($restrict_state < 1) {
                            $this->sendConfirmationMail($customer);
                        }
                        $restrict_state = (int)Configuration::get('PRIVATE_SIGNUP_RESTRICT');
                        if ($restrict_state > 0) {
                            $new_customer = $customer;
                            $new_customer->active = 0;
                            $new_customer->update();
                            Hook::exec('actionCustomerAccountAdd', array(
                                'newCustomer' => $new_customer,
                            ));
                            //Send email
                            $this->sendMailsUserPending($new_customer);
                            $result['errors'] = 0;
                            $result = Tools::jsonEncode($result);
                            $this->ajaxDie($result);
                        } else {
                            $result['errors'] = 0;
                            $result['redirect'] = true;
                            $result = Tools::jsonEncode($result);
                            $this->ajaxDie($result);
                        }
                    } else {
                        $result = Tools::jsonEncode($result);
                        $this->ajaxDie($result);
                    }
                }
            }
            $result = Tools::jsonEncode($result);
            $this->ajaxDie($result);
            die();
        }
    }

    private function sendMailsUserPending($customer)
    {
        //Send email to pending customer
        $module = new PrivateShop;
        $id_lang = (int)$this->context->language->id;
        $employee = new Employee(1);
        $admin_email = Configuration::get('PS_SHOP_EMAIL');
        $admin_email = (empty($admin_email)) ? $employee->email : $admin_email;
        $module->l('Account Pending Validation');
        $template_pending_customer = 'messageforpendingcustomer';
        $template_pending_customer_bo = 'messageforpendingcustomeradmin';
        $heading_pending_customer = $this->module->translations['pending_validation'];
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
            $this->context->shop->id
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
            $this->context->shop->id
        );
    }
    
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

    public function displayAjaxPrivateLogin()
    {
        $email = trim(Tools::getValue('email'));
        $passwd = trim(Tools::getValue('passwd'));
        $result = array();
        if (empty($email)) {
            $this->errors[] = $this->module->translations['email_required'];
            $result['errors'] = 1;
            $result['success'] = false;
            $result['html'] = $this->errors;
        } elseif (!Validate::isEmail($email)) {
            $this->errors[] = $this->module->translations['invalid_email'];
            $result['errors'] = 1;
            $result['success'] = false;
            $result['html'] = $this->errors;
        } elseif (empty($passwd)) {
            $this->errors[] = $this->module->translations['passwd_required'];
            $result['errors'] = 1;
            $result['success'] = false;
            $result['html'] = $this->errors;
        } elseif (!Validate::isPasswd($passwd)) {
            $this->errors[] = $this->module->translations['invalid_password'];
            $result['errors'] = 1;
            $result['success'] = false;
            $result['html'] = $this->errors;
        } else {
            $result['success'] = false;
            Hook::exec('actionAuthenticationBefore');

            $customer = new Customer();
            $authentication = $customer->getByEmail($email, $passwd);

            if (isset($authentication->active) && !$authentication->active) {
                $this->errors[] = $this->module->translations['account_deactive'];
                $result['success'] = false;
            } elseif (!$authentication || !$customer->id || $customer->is_guest) {
                $this->errors[] = $this->module->translations['auth_error'];
                $result['success'] = false;
            } else {

                if (true === Tools::version_compare(_PS_VERSION_, '1.7.0.0', '>=')) {
                    $this->context->updateCustomer($customer);
                    Hook::exec('actionAuthentication', array('customer' => $this->context->customer));
                } else {
                    $this->context->cookie->id_customer = (int)($customer->id);
                    $this->context->cookie->customer_lastname = $customer->lastname;
                    $this->context->cookie->customer_firstname = $customer->firstname;
                    $this->context->cookie->logged = 1;
                    $customer->logged = 1;
                    $this->context->cookie->is_guest = $customer->isGuest();
                    $this->context->cookie->passwd = $customer->passwd;
                    $this->context->cookie->email = $customer->email;
                    $this->context->customer = $customer;
                    if (Configuration::get('PS_CART_FOLLOWING') && (empty($this->context->cookie->id_cart) || Cart::getNbProducts($this->context->cookie->id_cart) == 0) && $id_cart = (int)Cart::lastNoneOrderedCart($this->context->customer->id)) {
                        $this->context->cart = new Cart($id_cart);
                    } else {
                        $id_carrier = (int)$this->context->cart->id_carrier;
                        $this->context->cart->id_carrier = 0;
                        $this->context->cart->setDeliveryOption(null);
                        $this->context->cart->id_address_delivery = (int)Address::getFirstCustomerAddressId((int)($customer->id));
                        $this->context->cart->id_address_invoice = (int)Address::getFirstCustomerAddressId((int)($customer->id));
                    }
                    $this->context->cart->id_customer = (int)$customer->id;
                    $this->context->cart->secure_key = $customer->secure_key;
                    if ($this->ajax && isset($id_carrier) && $id_carrier && Configuration::get('PS_ORDER_PROCESS_TYPE')) {
                        $delivery_option = array($this->context->cart->id_address_delivery => $id_carrier.',');
                        $this->context->cart->setDeliveryOption($delivery_option);
                    }
                    $this->context->cart->save();
                    $this->context->cookie->id_cart = (int)$this->context->cart->id;
                    $this->context->cookie->write();
                    $this->context->cart->autosetProductAddress();
                    Hook::exec('actionAuthentication');
                }
                // Login information have changed, so we check if the cart rules still apply
                CartRule::autoRemoveFromCart($this->context);
                CartRule::autoAddToCart($this->context);
                $result['success'] = true;
            }
            $result['html'] = $this->errors;
            $result['errors'] = count($this->errors);
        }
        $result = Tools::jsonEncode($result);
        $this->ajaxDie($result);
        die();
    }
}