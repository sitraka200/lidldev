<?php
/**
* PrivateShop
*
* Do not edit or add to this file.
* You are not authorized to modify, copy or redistribute this file.
* Permissions are reserved by FME Modules.
*
*  @author    FME Modules
*  @copyright 2018 FME Modules All right reserved
*  @license   FME Modules
*  @category  FMM Modules
*  @package   PrivateShop
*/

class AuthController extends AuthControllerCore
{
    protected function processSubmitLogin()
    {
        Hook::exec('actionBeforeAuthentication');
        $passwd = trim(Tools::getValue('passwd'));
        $email = trim(Tools::getValue('email'));
        if (empty($email)) {
            if (Configuration::get('PRIVATIZE_SHOP') == 'whole-shop') {
                $this->errors[] = Tools::displayError('An email address required.');
                FrontController::privateLogin();
            }
            else {
                $this->errors[] = Tools::displayError('An email address required.');
            }
        }
        elseif (!Validate::isEmail($email)) {
            if (Configuration::get('PRIVATIZE_SHOP') == 'whole-shop') {
                $this->errors[] = Tools::displayError('Invalid email address.');
                FrontController::privateLogin();
            }
            else {
                $this->errors[] = Tools::displayError('Invalid email address.');
            }
        }
        elseif (empty($passwd)) {
            if (Configuration::get('PRIVATIZE_SHOP') == 'whole-shop') {
                $this->errors[] = Tools::displayError('Password is required.');
                FrontController::privateLogin();
            }
            else {
                $this->errors[] = Tools::displayError('Password is required.');
            }
        }
        elseif (!Validate::isPasswd($passwd)) {
            if (Configuration::get('PRIVATIZE_SHOP') == 'whole-shop') {
                $this->errors[] = Tools::displayError('Invalid password.');
                FrontController::privateLogin();
            }
            else {
                $this->errors[] = Tools::displayError('Invalid password.');
            }
        }
        else {
            $customer = new Customer();
            $authentication = $customer->getByEmail(trim($email), trim($passwd));
            if (isset($authentication->active) && !$authentication->active) {
                if (Configuration::get('PRIVATIZE_SHOP') == 'whole-shop') {
                    $this->errors[] = Tools::displayError('Your account isn\'t available at this time, please contact us');
                    FrontController::privateLogin();
                }
                else {
                    $this->errors[] = Tools::displayError('Your account isn\'t available at this time, please contact us');
                }
            }
            elseif (!$authentication || !$customer->id) {
                if (Configuration::get('PRIVATIZE_SHOP') == 'whole-shop') {
                    $this->errors[] = Tools::displayError('Authentication failed.');
                    FrontController::privateLogin();
                }
                else {
                    $this->errors[] = Tools::displayError('Authentication failed.');
                }
            }
            else {
                $this->context->cookie->id_customer = (int)($customer->id);
                $this->context->cookie->customer_lastname = $customer->lastname;
                $this->context->cookie->customer_firstname = $customer->firstname;
                $this->context->cookie->logged = 1;
                $customer->logged = 1;
                $this->context->cookie->is_guest = $customer->isGuest();
                $this->context->cookie->passwd = $customer->passwd;
                $this->context->cookie->email = $customer->email;

                // Add customer to the context
                $this->context->customer = $customer;

                if (Configuration::get('PS_CART_FOLLOWING') && (empty($this->context->cookie->id_cart) || Cart::getNbProducts($this->context->cookie->id_cart) == 0) && $id_cart = (int)Cart::lastNoneOrderedCart($this->context->customer->id)) {
                    $this->context->cart = new Cart($id_cart);
                }
                else {
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

                // Login information have changed, so we check if the cart rules still apply
                CartRule::autoRemoveFromCart($this->context);
                CartRule::autoAddToCart($this->context);

                if (!$this->ajax && $back = Tools::getValue('back')) {
                    if ($back == Tools::secureReferrer(Tools::getValue('back'))) {
                        Tools::redirect(html_entity_decode($back));
                    }

                    $back = $back ? $back : 'my-account';
                    Tools::redirect('index.php?controller='.(($this->authRedirection !== false) ? urlencode($this->authRedirection) : $back));
                }
            }
        }
        if ($this->ajax) {
            $return = array(
                'hasError' => !empty($this->errors),
                'errors' => $this->errors,
                'token' => Tools::getToken(false)
            );
            $this->ajaxDie(Tools::jsonEncode($return));
        }
        else {
            $this->context->smarty->assign('authentification_error', $this->errors);
        }
    }

    protected function processSubmitAccount()
    {
        $persist = 2;
        Hook::exec('actionBeforeSubmitAccount');
        $this->create_account = true;
        if (Tools::isSubmit('submitAccount')) {
            $this->context->smarty->assign('email_create', 1);
        }
        // New Guest customer
        if (!Tools::getValue('is_new_customer', 1) && !Configuration::get('PS_GUEST_CHECKOUT_ENABLED')) {
            $this->errors[] = Tools::displayError('You cannot create a guest account.');
            FrontController::privateLogin($persist);
        }
        if (!Tools::getValue('is_new_customer', 1)) {
            $_POST['passwd'] = md5(time()._COOKIE_KEY_);
        }
        if ($guest_email = Tools::getValue('guest_email')) {
            $_POST['email'] = $guest_email;
        }
        // Checked the user address in case he changed his email address
        if (Validate::isEmail($email = Tools::getValue('email')) && !empty($email))
            if (Customer::customerExists($email)) {
                $this->errors[] = Tools::displayError('An account using this email address has already been registered.', false);
                FrontController::privateLogin($persist);
            }
        // Preparing customer
        $customer = new Customer();
        $lastnameAddress = Tools::getValue('lastname');
        $firstnameAddress = Tools::getValue('firstname');
        $_POST['lastname'] = Tools::getValue('customer_lastname', $lastnameAddress);
        $_POST['firstname'] = Tools::getValue('customer_firstname', $firstnameAddress);
        $addresses_types = array('address');
        if (!Configuration::get('PS_ORDER_PROCESS_TYPE') && Configuration::get('PS_GUEST_CHECKOUT_ENABLED') && Tools::getValue('invoice_address')) {
            $addresses_types[] = 'address_invoice';
        }

        $error_phone = false;
        if (Configuration::get('PS_ONE_PHONE_AT_LEAST')) {
            if (Tools::isSubmit('submitGuestAccount') || !Tools::getValue('is_new_customer')) {
                if (!Tools::getValue('phone') && !Tools::getValue('phone_mobile'))
                    $error_phone = true;
            }
            elseif (((Configuration::get('PS_REGISTRATION_PROCESS_TYPE') && Configuration::get('PS_ORDER_PROCESS_TYPE'))
                    || (Configuration::get('PS_ORDER_PROCESS_TYPE') && !Tools::getValue('email_create'))
                    || (Configuration::get('PS_REGISTRATION_PROCESS_TYPE') && Tools::getValue('email_create')))
                    && (!Tools::getValue('phone') && !Tools::getValue('phone_mobile'))) {
                $error_phone = true;
            }
        }

        if ($error_phone) {
            $this->errors[] = Tools::displayError('You must register at least one phone number.');
            FrontController::privateLogin($persist);
        }

        $this->errors = array_unique(array_merge($this->errors, $customer->validateController()));

        // Check the requires fields which are settings in the BO
        $this->errors = $this->errors + $customer->validateFieldsRequiredDatabase();

        if (!Configuration::get('PS_REGISTRATION_PROCESS_TYPE') && !$this->ajax && !Tools::isSubmit('submitGuestAccount')) {
            if (!count($this->errors)) {
                if (Tools::isSubmit('newsletter')) {
                    $this->processCustomerNewsletter($customer);
                }

                $customer->firstname = Tools::ucwords($customer->firstname);
                $y = Tools::getValue('years');
                $m = Tools::getValue('months');
                $d = Tools::getValue('days');
                $customer->birthday = (empty($y) ? '' : (int)$y.'-'.(int)$m.'-'.(int)$d);
                if (!Validate::isBirthDate($customer->birthday)) {
                    $customer->birthday = '';
                    //FrontController::privateLogin();
                }

                // New Guest customer
                $customer->is_guest = (Tools::isSubmit('is_new_customer') ? !Tools::getValue('is_new_customer', 1) : 0);
                $customer->active = 1;

                if (!count($this->errors)) {
                    if ($customer->add()) {
                        $multi = '';
                        if (!$customer->is_guest)
                            if (!$this->sendConfirmationMail($customer)) {
                                //$this->errors[] = Tools::displayError('The email cannot be sent.');
                                //FrontController::privateLogin($persist);
                            }

                        $this->updateContext($customer);

                        $this->context->cart->update();
                        Hook::exec('actionCustomerAccountAdd', array(
                                '_POST' => $_POST,
                                'newCustomer' => $customer
                            ));
                        if ($this->ajax) {
                            $return = array(
                                'hasError' => !empty($this->errors),
                                'errors' => $this->errors,
                                'isSaved' => true,
                                'id_customer' => (int)$this->context->cookie->id_customer,
                                'id_address_delivery' => $this->context->cart->id_address_delivery,
                                'id_address_invoice' => $this->context->cart->id_address_invoice,
                                'token' => Tools::getToken(false)
                            );
                            $this->ajaxDie(Tools::jsonEncode($return));
                        }
                        $restrict_state = (int)Configuration::get('PRIVATE_SIGNUP_RESTRICT');
                        if ($restrict_state > 0) {
                            //Let make cookie so we know if restricted is valid
                            $this->context->cookie->privateshop_restricted = true;
                            $this->context->cookie->write();
                            FrontController::privateLogin($persist);
                        }
                        else {
                            if (($back = Tools::getValue('back')) && $back == Tools::secureReferrer($back)) {
                                Tools::redirect(html_entity_decode($back));
                            }
                            // redirection: if cart is not empty : redirection to the cart
                            if (count($this->context->cart->getProducts(true)) > 0) {
                                Tools::redirect('index.php?controller=order'.($multi = (int)Tools::getValue('multi-shipping') ? '&multi-shipping='.$multi : ''));
                            }
                             //else : redirection to the account
                            else {
                                Tools::redirect('index.php?controller='.(($this->authRedirection !== false) ? urlencode($this->authRedirection) : 'my-account'));
                            }
                        }
                    }
                    else {
                        $this->errors[] = Tools::displayError('An error occurred while creating your account.');
                        FrontController::privateLogin($persist);
                    }
                }
            }
            else {
                FrontController::privateLogin($persist);
            }
        }
        else {
            $_POST['lastname'] = $lastnameAddress;
            $_POST['firstname'] = $firstnameAddress;
            $post_back = $_POST;
            // Preparing addresses
            foreach ($addresses_types as $addresses_type) {
                $$addresses_type = new Address();
                $$addresses_type->id_customer = 1;

                if ($addresses_type == 'address_invoice') {
                    foreach ($_POST as $key => &$post) {
                        if ($tmp = Tools::getValue($key.'_invoice')) {
                            $post = $tmp;
                        }
                    }
                }

                $this->errors = array_unique(array_merge($this->errors, $$addresses_type->validateController()));
                if ($addresses_type == 'address_invoice') {
                    $_POST = $post_back;
                }

                if (!($country = new Country($$addresses_type->id_country)) || !Validate::isLoadedObject($country)) {
                    $this->errors[] = Tools::displayError('Country cannot be loaded with address->id_country');
                    FrontController::privateLogin($persist);
                }

                if (!$country->active) {
                    $this->errors[] = Tools::displayError('This country is not active.');
                    FrontController::privateLogin($persist);
                }

                $postcode = $$addresses_type->postcode;
                /* Check zip code format */
                if ($country->zip_code_format && !$country->checkZipCode($postcode)) {
                    $this->errors[] = sprintf(Tools::displayError('The Zip/Postal code you\'ve entered is invalid. It must follow this format: %s'), str_replace('C', $country->iso_code, str_replace('N', '0', str_replace('L', 'A', $country->zip_code_format))));
                    FrontController::privateLogin($persist);
                }
                elseif (empty($postcode) && $country->need_zip_code) {
                    $this->errors[] = Tools::displayError('A Zip / Postal code is required.');
                    FrontController::privateLogin($persist);
                }
                elseif ($postcode && !Validate::isPostCode($postcode)) {
                    $this->errors[] = Tools::displayError('The Zip / Postal code is invalid.');
                    FrontController::privateLogin($persist);
                }

                if ($country->need_identification_number && (!Tools::getValue('dni') || !Validate::isDniLite(Tools::getValue('dni')))) {
                    $this->errors[] = Tools::displayError('The identification number is incorrect or has already been used.');
                    FrontController::privateLogin($persist);
                }
                elseif (!$country->need_identification_number) {
                    $$addresses_type->dni = null;
                }

                if (Tools::isSubmit('submitAccount') || Tools::isSubmit('submitGuestAccount'))
                    if (!($country = new Country($$addresses_type->id_country, Configuration::get('PS_LANG_DEFAULT'))) || !Validate::isLoadedObject($country)) {
                        $this->errors[] = Tools::displayError('Country is invalid');
                        FrontController::privateLogin($persist);
                    }
                $contains_state = isset($country) && is_object($country) ? (int)$country->contains_states: 0;
                $id_state = isset($$addresses_type) && is_object($$addresses_type) ? (int)$$addresses_type->id_state: 0;
                if ((Tools::isSubmit('submitAccount') || Tools::isSubmit('submitGuestAccount')) && $contains_state && !$id_state) {
                        $this->errors[] = Tools::displayError('This country requires you to choose a State.');
                        FrontController::privateLogin($persist);
                    }
            }
        }
        $_m = Tools::getValue('months');
        $_d = Tools::getValue('days');
        $_y = Tools::getValue('years');
        //if (!@checkdate($_m, $_d, $_y) && !($_m == '' && $_d == '' && $_y == '')) {
        //  $this->errors[] = Tools::displayError('Invalid date of birth');
        //  FrontController::privateLogin();
        //}

        if (!count($this->errors)) {
            if (Customer::customerExists(Tools::getValue('email'))) {
                $this->errors[] = Tools::displayError('An account using this email address has already been registered. Please enter a valid password or request a new one. ', false);
                FrontController::privateLogin($persist);
            }
            if (Tools::isSubmit('newsletter')) {
                $this->processCustomerNewsletter($customer);
            }

            $customer->birthday = ($_y ? '' : (int)$_y.'-'.(int)$_m.'-'.(int)$_d);
            if (!Validate::isBirthDate($customer->birthday)) {
                $customer->birthday = '';
                //FrontController::privateLogin();
            }

            if (!count($this->errors)) {
                $customer->active = 1;
                // New Guest customer
                if (Tools::isSubmit('is_new_customer')) {
                    $customer->is_guest = !Tools::getValue('is_new_customer', 1);
                }
                else {
                    $customer->is_guest = 0;
                }
                if (!$customer->add()) {
                    $this->errors[] = Tools::displayError('An error occurred while creating your account.');
                    FrontController::privateLogin($persist);
                }
                else {
                    foreach ($addresses_types as $addresses_type) {
                        $$addresses_type->id_customer = (int)$customer->id;
                        if ($addresses_type == 'address_invoice') {
                            foreach ($_POST as $key => &$post) {
                                if ($tmp = Tools::getValue($key.'_invoice')) {
                                    $post = $tmp;
                                }
                            }
                        }

                        $this->errors = array_unique(array_merge($this->errors, $$addresses_type->validateController()));
                        if ($addresses_type == 'address_invoice') {
                            $_POST = $post_back;
                        }
                        if (!count($this->errors) && (Configuration::get('PS_REGISTRATION_PROCESS_TYPE') || $this->ajax || Tools::isSubmit('submitGuestAccount')) && !$$addresses_type->add()) {
                            $this->errors[] = Tools::displayError('An error occurred while creating your address.');
                            FrontController::privateLogin($persist);
                        }
                    }
                    if (!count($this->errors)) {
                        if (!$customer->is_guest)
                        {
                            $this->context->customer = $customer;
                            $customer->cleanGroups();
                            // we add the guest customer in the default customer group
                            $customer->addGroups(array((int)Configuration::get('PS_CUSTOMER_GROUP')));
                            if (!$this->sendConfirmationMail($customer)) {
                                $this->errors[] = Tools::displayError('The email cannot be sent.');
                                FrontController::privateLogin($persist);
                            }
                        }
                        else {
                            $customer->cleanGroups();
                            // we add the guest customer in the guest customer group
                            $customer->addGroups(array((int)Configuration::get('PS_GUEST_GROUP')));
                        }
                        $this->updateContext($customer);
                        $this->context->cart->id_address_delivery = (int)Address::getFirstCustomerAddressId((int)$customer->id);
                        $this->context->cart->id_address_invoice = (int)Address::getFirstCustomerAddressId((int)$customer->id);
                        // if (isset($address_invoice) && Validate::isLoadedObject($address_invoice))
                        //  $this->context->cart->id_address_invoice = (int)$address_invoice->id;

                        if ($this->ajax && Configuration::get('PS_ORDER_PROCESS_TYPE')) {
                            $delivery_option = array((int)$this->context->cart->id_address_delivery => (int)$this->context->cart->id_carrier.',');
                            $this->context->cart->setDeliveryOption($delivery_option);
                        }

                        // If a logged guest logs in as a customer, the cart secure key was already set and needs to be updated
                        $this->context->cart->update();

                        // Avoid articles without delivery address on the cart
                        $this->context->cart->autosetProductAddress();

                        Hook::exec('actionCustomerAccountAdd', array(
                                '_POST' => $_POST,
                                'newCustomer' => $customer
                            ));
                        if ($this->ajax) {
                            $return = array(
                                'hasError' => !empty($this->errors),
                                'errors' => $this->errors,
                                'isSaved' => true,
                                'id_customer' => (int)$this->context->cookie->id_customer,
                                'id_address_delivery' => $this->context->cart->id_address_delivery,
                                'id_address_invoice' => $this->context->cart->id_address_invoice,
                                'token' => Tools::getToken(false)
                            );
                            $this->ajaxDie(Tools::jsonEncode($return));
                        }
                        // if registration type is in two steps, we redirect to register address
                        //if (!Configuration::get('PS_REGISTRATION_PROCESS_TYPE') && !$this->ajax && !Tools::isSubmit('submitGuestAccount')) {
                        //  Tools::redirect('index.php?controller=address');
                        //}

                        //if (($back = Tools::getValue('back')) && $back == Tools::secureReferrer($back)) {
                        //  Tools::redirect(html_entity_decode($back));
                        //}

                        // redirection: if cart is not empty : redirection to the cart
                        //if (count($this->context->cart->getProducts(true)) > 0) {
                        //  Tools::redirect('index.php?controller=order'.($multi = (int)Tools::getValue('multi-shipping') ? '&multi-shipping='.$multi : ''));
                        //}
                        // else : redirection to the account
                        //else {
                        //  Tools::redirect('index.php?controller='.(($this->authRedirection !== false) ? urlencode($this->authRedirection) : 'my-account'));
                        //}
                    }
                }
            }
        }

        if (count($this->errors)) {
            //for retro compatibility to display guest account creation form on authentication page
            if (Tools::getValue('submitGuestAccount')) {
                $_GET['display_guest_checkout'] = 1;
            }

            if (!Tools::getValue('is_new_customer')) {
                unset($_POST['passwd']);
            }
            if ($this->ajax) {
                $return = array(
                    'hasError' => !empty($this->errors),
                    'errors' => $this->errors,
                    'isSaved' => false,
                    'id_customer' => 0
                );
                $this->ajaxDie(Tools::jsonEncode($return));
            }
            $this->context->smarty->assign('account_error', $this->errors);
        }
    }
}
