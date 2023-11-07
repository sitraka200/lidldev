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
class PrivateShopThejaxModuleFrontControllerOverride extends PrivateShopThejaxModuleFrontController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function initContent()
    {
        ModuleFrontController::initContent();
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
            
            /* PROCESS NEW FIELDS */
            $matricule = Tools::getValue('matricule');
            $address1 = Tools::getValue('address');
            $postcode = Tools::getValue('postcode');
            $city = Tools::getValue('city');
            $phone = Tools::getValue('phone');
            $cgu = Tools::getValue('psgdpr_consent_checkbox');
            $confidential = Tools::getValue('psgdpr_consent_checkbox');
            $gcaptcha = (int) (Tools::getValue('g-recaptcha-response') );

            /**
             * @see https://www.kaplankomputing.com/blog/tutorials/recaptcha-php-demo-tutorial/
             */
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $data = array(
                'secret' => '6LfDebwUAAAAAA4-IiPwaiYC1EuflHI8JcccH5jw',
                'response' => Tools::getValue('g-recaptcha-response')
            );
            $options = array(
                'http' => array (
                    'method' => 'POST',
                    'header' =>
                        "Content-Type: application/x-www-form-urlencoded\r\n",
                    'content' => http_build_query($data)
                )
            );
            $context = stream_context_create($options);
            $verify = file_get_contents($url, false, $context);
            $captcha_success = json_decode($verify);

            // $pre = var_export($captcha_success, true);

            // file_put_contents('file.txt', $pre);

            // $ssss = var_export($_POST["g-recaptcha-response"] . ' ', true);
            // file_put_contents('file.txt', $ssss, FILE_APPEND);

            // $ssss = var_export(Tools::getValue('g-recaptcha-response') . ' ', true);
            // file_put_contents('file.txt', $ssss, FILE_APPEND);

            /* END PROCESSING NEW FIELDS */

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
            }
            
            /* VALIDATE NEW FIELDS */
            elseif (empty($matricule)) {
                $this->errors[] = $this->module->translations['matricule_required'];
                $result['errors'] = 1;
                $result['html'] = $this->errors;
            } 
            // elseif (!Validate::isInt($matricule)) {
            //     $this->errors[] = $this->module->translations['invalid_matricule'];
            //     $result['errors'] = 1;
            //     $result['html'] = $this->errors;
            // } 
            elseif (empty($address1)) {
                $this->errors[] = $this->module->translations['address_required'];
                $result['errors'] = 1;
                $result['html'] = $this->errors;
            } elseif (!Validate::isAddress($address1)) {
                $this->errors[] = $this->module->translations['invalid_address'];
                $result['errors'] = 1;
                $result['html'] = $this->errors;
            } elseif (empty($postcode)) {
                $this->errors[] = $this->module->translations['zipcode_required'];
                $result['errors'] = 1;
                $result['html'] = $this->errors;
            } elseif (!Validate::isPostCode($postcode)) {
                $this->errors[] = $this->module->translations['invalid_zipcode'];
                $result['errors'] = 1;
                $result['html'] = $this->errors;
            } elseif (empty($city)) {
                $this->errors[] = $this->module->translations['city_required'];
                $result['errors'] = 1;
                $result['html'] = $this->errors;
            } elseif (!Validate::isCityName($city)) {
                $this->errors[] = $this->module->translations['invalid_city'];
                $result['errors'] = 1;
                $result['html'] = $this->errors;
            } elseif (empty($phone)) {
                $this->errors[] = $this->module->translations['phone_required'];
                $result['errors'] = 1;
                $result['html'] = $this->errors;
            } elseif (!Validate::isPhoneNumber($phone)) {
                $this->errors[] = $this->module->translations['invalid_phone'];
                $result['errors'] = 1;
                $result['html'] = $this->errors;
            } elseif (!$gcaptcha || $captcha_success->success == false) {
                $this->errors[] = $this->module->translations['gcaptcha_error'];
                $result['errors'] = 1;
                $result['html'] = $this->errors;
            }

            /* END VALIDATING NEW FIELD */

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
                $customer->matricule = $matricule;
                $customer->cgu = $cgu;
                $customer->confidential = $confidential;
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
                        /* CREATE CUSTOMER ADDRESS */
                        $address = new Address(
                            null,
                            $this->context->language->id
                        );                    

                        $address->id_country = (int) Tools::getCountry();
                        $address->address1 = $address1;
                        $address->postcode = $postcode;
                        $address->city = $city;
                        $address->phone = $phone;
                        
                        $address->firstname = $customer->firstname;
                        $address->lastname = $customer->lastname;
                        $address->id_customer = (int) $customer->id;
                        
                        $address->id_state = 0;
                        $address->alias = $this->module->l('My Address');                    
                        
                        if (!$address->save()) {
                            $customer->delete();
                            $this->errors[] = $this->module->translations['address_saving_error'];
                            $result['errors'] = 1;
                            $result['html'] = $this->errors;
                            $result = Tools::jsonEncode($result);
                            $this->ajaxDie($result);
                            die();
                        }
                        /* END CREATING ADDRESS */
                        
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
}