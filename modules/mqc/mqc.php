<?php
/**
 * PrestaShop module created by VEKIA, a guy from official PrestaShop community ;-)
 *
 * @author    VEKIA https://www.prestashop.com/forums/user/132608-vekia/
 * @copyright 2010-2019 VEKIA
 * @license   This program is not free software and you can't resell and redistribute it
 *
 * CONTACT WITH DEVELOPER
 * support@mypresta.eu
 */
if (!defined('_PS_VERSION_'))
{
    exit;
}

class Mqc extends Module
{
    public function __construct()
    {
        $this->_html = '';
        $this->name = 'mqc';
        $this->tab = 'checkout';
        $this->author = 'MyPresta.eu';
        $this->mypresta_link = 'https://mypresta.eu/modules/ordering-process/maximum-product-quantity.html';
        $this->module_key = '0c978025ffc9a0d1f0cca77838871ce4';
        $this->version = '1.8.1';
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = $this->l('Maximum product quantity per customer');
        $this->description = $this->l('With this module you can define maximum quantity of product per customer group. Customers will not be able to order more products.');
    }

    public function hookactionAdminControllerSetMedia($params)
    {
        //for update feature purposes
    }

    public function inconsistency($ret){
        return;
    }

    public function checkforupdates($display_msg = 0, $form = 0)
    {
        // ---------- //
        // ---------- //
        // VERSION 16 //
        // ---------- //
        // ---------- //
        $this->mkey = "nlc";
        if (@file_exists('../modules/' . $this->name . '/key.php')) {
            @require_once('../modules/' . $this->name . '/key.php');
        } else {
            if (@file_exists(dirname(__FILE__) . $this->name . '/key.php')) {
                @require_once(dirname(__FILE__) . $this->name . '/key.php');
            } else {
                if (@file_exists('modules/' . $this->name . '/key.php')) {
                    @require_once('modules/' . $this->name . '/key.php');
                }
            }
        }
        if ($form == 1) {
            return '
            <div class="panel" id="fieldset_myprestaupdates" style="margin-top:20px;">
            ' . ($this->psversion() == 6 || $this->psversion() == 7 ? '<div class="panel-heading"><i class="icon-wrench"></i> ' . $this->l('MyPresta updates') . '</div>' : '') . '
			<div class="form-wrapper" style="padding:0px!important;">
            <div id="module_block_settings">
                    <fieldset id="fieldset_module_block_settings">
                         ' . ($this->psversion() == 5 ? '<legend style="">' . $this->l('MyPresta updates') . '</legend>' : '') . '
                        <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
                            <label>' . $this->l('Check updates') . '</label>
                            <div class="margin-form">' . (Tools::isSubmit('submit_settings_updates_now') ? ($this->inconsistency(0) ? '' : '') . $this->checkforupdates(1) : '') . '
                                <button style="margin: 0px; top: -3px; position: relative;" type="submit" name="submit_settings_updates_now" class="button btn btn-default" />
                                <i class="process-icon-update"></i>
                                ' . $this->l('Check now') . '
                                </button>
                            </div>
                            <label>' . $this->l('Updates notifications') . '</label>
                            <div class="margin-form">
                                <select name="mypresta_updates">
                                    <option value="-">' . $this->l('-- select --') . '</option>
                                    <option value="1" ' . ((int)(Configuration::get('mypresta_updates') == 1) ? 'selected="selected"' : '') . '>' . $this->l('Enable') . '</option>
                                    <option value="0" ' . ((int)(Configuration::get('mypresta_updates') == 0) ? 'selected="selected"' : '') . '>' . $this->l('Disable') . '</option>
                                </select>
                                <p class="clear">' . $this->l('Turn this option on if you want to check MyPresta.eu for module updates automatically. This option will display notification about new versions of this addon.') . '</p>
                            </div>
                            <label>' . $this->l('Module page') . '</label>
                            <div class="margin-form">
                                <a style="font-size:14px;" href="' . $this->mypresta_link . '" target="_blank">' . $this->displayName . '</a>
                                <p class="clear">' . $this->l('This is direct link to official addon page, where you can read about changes in the module (changelog)') . '</p>
                            </div>
                            <div class="panel-footer">
                                <button type="submit" name="submit_settings_updates"class="button btn btn-default pull-right" />
                                <i class="process-icon-save"></i>
                                ' . $this->l('Save') . '
                                </button>
                            </div>
                        </form>
                    </fieldset>
                    <style>
                    #fieldset_myprestaupdates {
                        display:block;clear:both;
                        float:inherit!important;
                    }
                    </style>
                </div>
            </div>
            </div>';
        } else {
            if (defined('_PS_ADMIN_DIR_')) {
                if (Tools::isSubmit('submit_settings_updates')) {
                    Configuration::updateValue('mypresta_updates', Tools::getValue('mypresta_updates'));
                }
                if (Configuration::get('mypresta_updates') != 0 || (bool)Configuration::get('mypresta_updates') != false) {
                    if (Configuration::get('update_' . $this->name) < (date("U") - 259200)) {
                        $actual_version = mqcUpdate::verify($this->name, (isset($this->mkey) ? $this->mkey : 'nokey'), $this->version);
                    }
                    if (mqcUpdate::version($this->version) < mqcUpdate::version(Configuration::get('updatev_' . $this->name)) && Tools::getValue('ajax', 'false') == 'false') {
                        $this->context->controller->warnings[] = '<strong>' . $this->displayName . '</strong>: ' . $this->l('New version available, check http://MyPresta.eu for more informations') . ' <a href="' . $this->mypresta_link . '">' . $this->l('More details in changelog') . '</a>';
                        $this->warning = $this->context->controller->warnings[0];
                    }
                } else {
                    if (Configuration::get('update_' . $this->name) < (date("U") - 259200)) {
                        $actual_version = mqcUpdate::verify($this->name, (isset($this->mkey) ? $this->mkey : 'nokey'), $this->version);
                    }
                }
                if ($display_msg == 1) {
                    if (mqcUpdate::version($this->version) < mqcUpdate::version(mqcUpdate::verify($this->name, (isset($this->mkey) ? $this->mkey : 'nokey'), $this->version))) {
                        return "<span style='color:red; font-weight:bold; font-size:16px; margin-right:10px;'>" . $this->l('New version available!') . "</span>";
                    } else {
                        return "<span style='color:green; font-weight:bold; font-size:16px; margin-right:10px;'>" . $this->l('Module is up to date!') . "</span>";
                    }
                }
            }
        }
    }

    public static function psversion($part = 1)
    {
        $version = _PS_VERSION_;
        $exp = explode('.', $version);
        if ($part == 1)
        {
            return $exp[1];
        }
        if ($part == 2)
        {
            return $exp[2];
        }
        if ($part == 3)
        {
            return $exp[3];
        }
    }

    public function install()
    {
        if (parent::install() == false ||
            !$this->changeCoreJs() ||
            !Configuration::updateValue('update_' . $this->name, '0') ||
            !$this->registerHook('actionAdminControllerSetMedia') ||
            !$this->registerHook('displayAdminProductsExtra') ||
            !$this->registerHook('actionProductUpdate') ||
            !$this->registerHook('actionCartSave') ||
            !$this->registerHook('actionAuthentication') ||
            !$this->registerHook('displayShoppingCart') ||
            !$this->registerHook('displayPaymentTop') ||
            !$this->installdb() ||
            !$this->registerHook('header') ||
            !$this->registerHook('productActions'))
        {
            return false;
        }
        return true;
    }

    public function uninstall()
    {
        parent::uninstall();
        return $this->changeCoreJsUninstall();
    }

    private function installdb()
    {
        $prefix = _DB_PREFIX_;
        $statements = array();
        $statements[] = "CREATE TABLE IF NOT EXISTS `${prefix}mqc` (" . '`id` int(10) NOT NULL AUTO_INCREMENT,' . '`id_product` INT(9),' . '`group` INT(3),' . '`shop` INT(4),' . '`quantity` INT(7),' . ' PRIMARY KEY (`id`)' . ')';
        $statements[] = "CREATE TABLE IF NOT EXISTS `${prefix}mqc_attributes` ( `id` int(10) NOT NULL AUTO_INCREMENT, `id_product` int(9) DEFAULT NULL, `id_attribute` int(9) DEFAULT NULL, `group` int(3) DEFAULT NULL, `shop` int(4) DEFAULT NULL, `quantity` int(7) DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $statements[] = "CREATE TABLE IF NOT EXISTS `${prefix}mqc_orders` (" . '`id` int(10) NOT NULL AUTO_INCREMENT,' . '`id_product` INT(9),' . '`group` INT(3),' . '`shop` INT(4),' . '`quantity` INT(7),' . ' PRIMARY KEY (`id`)' . ')';

        foreach ($statements as $statement)
        {
            if (!Db::getInstance()->Execute($statement))
            {
                return false;
            }
        }
        return true;
    }

    public function changeCoreJs()
    {
        if (Tools::version_compare(_PS_VERSION_, '1.7.5.0', '>=')) {
            $contents     = file_get_contents('../themes/core.js');
            $replacement  = "linkAction: (typeof e.hasError !== 'undefined' ? (e.hasError == true  ? 'show-error':'add-to-cart'):'add-to-cart'),\n";
            $new_contents = str_replace('linkAction:"add-to-cart",', $replacement, $contents);
            file_put_contents('../themes/core.js', $new_contents);
        } else {
            $data = file('../themes/core.js');
            function replace_a_line($data)
            {
                if (stristr($data, 'linkAction: \'add-to-cart\',')) {
                    return "linkAction: (typeof resp.hasError !== 'undefined' ? (resp.hasError == true  ? 'show-error':'add-to-cart'):'add-to-cart'), resp: resp, \n";
                }

                return $data;
            }

            $data = array_map('replace_a_line', $data);
            file_put_contents('../themes/core.js', implode('', $data));
        }

        return true;
    }

    public function changeCoreJsUninstall()
    {
        if (Tools::version_compare(_PS_VERSION_, '1.7.5.0', '>=')) {
            $contents     = file_get_contents('../themes/core.js');
            $replacement  = 'linkAction:"add-to-cart",';
            $new_contents = str_replace("linkAction: (typeof e.hasError !== 'undefined' ? (e.hasError == true  ? 'show-error':'add-to-cart'):'add-to-cart'),\n", $replacement, $contents);
            file_put_contents('../themes/core.js', $new_contents);
        } else {
            $data = file('../themes/core.js');
            function replace_a_line($data)
            {
                if (stristr($data, "linkAction: (typeof resp.hasError !== 'undefined' ? (resp.hasError == true  ? 'show-error':'add-to-cart'):'add-to-cart'), resp: resp, ")) {
                    return 'linkAction: \'add-to-cart\',' . "\n";
                }

                return $data;
            }

            $data = array_map('replace_a_line', $data);
            file_put_contents('../themes/core.js', implode('', $data));
        }

        return true;
    }

    public function runStatement($statement)
    {
        if (!Db::getInstance()->Execute($statement))
        {
            return false;
        }
        return true;
    }

    public function getRestrictions($id_product)
    {
        return Db::getInstance()->ExecuteS('SELECT * FROM `' . _DB_PREFIX_ . 'mqc` WHERE id_product = ' . (int)$id_product . '');
    }

    public static function getRestrictionsByGroup($id_product, $group)
    {
        $restriction = Db::getInstance()->getRow('SELECT * FROM `' . _DB_PREFIX_ . 'mqc` WHERE id_product = ' . (int)$id_product . ' AND `group` = ' . (int)$group . '');

        if ($restriction['quantity'] == null || $restriction == false || $restriction['quantity'] == '')
        {
            if (Configuration::get('MQC_GL') == 1)
            {
                $restriction['quantity'] = (is_int((int)Configuration::get('MQC_GLV')) ? Configuration::get('MQC_GLV') : 1);
                return $restriction;
            }
        }
        else
        {
            return $restriction;
        }
    }

    public static function getRestrictionsByGroupAdmin($id_product, $group)
    {
        return Db::getInstance()->getRow('SELECT * FROM `' . _DB_PREFIX_ . 'mqc` WHERE id_product = ' . (int)$id_product . ' AND `group` = ' . (int)$group . '');
    }

    public static function getRestrictionsByGroupValue($id_product, $group)
    {
        $query = Db::getInstance()->getRow('SELECT quantity FROM `' . _DB_PREFIX_ . 'mqc` WHERE id_product = ' . (int)$id_product . ' AND `group` = ' . (int)$group . '');
        if ($query != false)
        {
            return $query['quantity'];
        }
        else
        {
            return false;
        }
    }

    public function getRestrictionsAttributesByGroup($id_product, $id_attribute, $group)
    {
        $restriction = Db::getInstance()->getRow('SELECT * FROM `' . _DB_PREFIX_ . 'mqc_attributes` WHERE id_attribute=' . (int)$id_attribute . ' AND id_product = ' . (int)$id_product . ' AND `group` = ' . (int)$group . '');
        if ($restriction['quantity'] == null || $restriction == false || $restriction['quantity'] == '')
        {
            if (Configuration::get('MQC_GL') == 1)
            {
                $restriction['quantity'] = (is_int((int)Configuration::get('MQC_GLV')) ? Configuration::get('MQC_GLV') : 1);
                $restriction['id_attribute'] = $id_attribute;
                return $restriction;
            }
        }
        else
        {
            return $restriction;
        }
    }

    public static function getRestrictionsAttributesByGroupAdmin($id_product, $id_attribute, $group)
    {
        return Db::getInstance()->getRow('SELECT * FROM `' . _DB_PREFIX_ . 'mqc_attributes` WHERE id_attribute=' . (int)$id_attribute . ' AND id_product = ' . (int)$id_product . ' AND `group` = ' . (int)$group . '');
    }

    public static function getRestrictionsAttributesByGroupValue($id_product, $id_attribute, $group)
    {
        $query = Db::getInstance()->getRow('SELECT quantity FROM `' . _DB_PREFIX_ . 'mqc_attributes` WHERE id_attribute=' . (int)$id_attribute . ' AND id_product = ' . (int)$id_product . ' AND `group` = ' . (int)$group . '');
        if ($query != false)
        {
            return $query['quantity'];
        }
        else
        {
            return false;
        }
    }

    public static function getRestrictionsTotalByGroupAdmin($id_product, $group)
    {
        return Db::getInstance()->getRow('SELECT * FROM `' . _DB_PREFIX_ . 'mqc_orders` WHERE id_product = ' . (int)$id_product . ' AND `group` = ' . (int)$group . '');
    }

    public static function getRestrictionsTotalByGroupValue($id_product, $group)
    {
        $query = Db::getInstance()->getRow('SELECT quantity FROM `' . _DB_PREFIX_ . 'mqc_orders` WHERE id_product = ' . (int)$id_product . ' AND `group` = ' . (int)$group . '');
        if ($query != false)
        {
            return $query['quantity'];
        }
        else
        {
            return false;
        }
    }

    public function cleanUpAttributesCartGlobalAspect($params, $restriction_quantity, $id_product, $id_attribute, $id_cart)
    {
        if (isset($global_limit_attribute[$id_product][$id_attribute]))
        {
            unset($global_limit_attribute[$id_product][$id_attribute]);
        }
        $global_limit_attribute[$id_product][$id_attribute] = 0;
        $count = 0;
        $todelete = array();
        $toupdate = array();
        if (method_exists($params['cart'], 'getProducts'))
        {
            $cart = new Cart($params['cart']->id);
            foreach ($cart->getProducts() as $product)
            {
                if ($product['id_product'] == $id_product && $product['id_product_attribute'] == $id_attribute)
                {
                    $global_limit_attribute[$id_product][$id_attribute] = $global_limit_attribute[$id_product][$id_attribute] + $product['quantity'];
                }
            }
        }
        if (isset($global_limit_attribute[$id_product][$id_attribute]))
        {
            if ($global_limit_attribute[$id_product][$id_attribute] > $restriction_quantity)
            {
                Db::getInstance()->execute('UPDATE `' . _DB_PREFIX_ . 'cart_product` SET quantity=' . (int)$restriction_quantity . ' WHERE `id_cart` = ' . (int)$id_cart . ' AND `id_product` = ' . (int)$id_product . ' AND `id_product_attribute`=' . $id_attribute);
            }
        }
    }

    public function cleanUpNewCartGlobalAspect($params, $restriction_quantity, $id_product, $id_cart)
    {
        if (isset($global_limit[$id_product]))
        {
            unset($global_limit[$id_product]);
        }
        $count = 0;
        $todelete = array();
        $toupdate = array();
        if (method_exists($params['cart'], 'getProducts'))
        {
            $cart = new Cart($params['cart']->id);
            foreach ($cart->getProducts() as $product)
            {
                if ($product['id_product'] == $id_product)
                {
                    $count++;
                    if (!isset($global_limit[$id_product]))
                    {
                        $global_limit[$id_product] = 0;
                    }
                    $global_limit[$id_product] = (int)$global_limit[$id_product] + (int)$product['quantity'];
                    if ($global_limit[$id_product] > $restriction_quantity)
                    {
                        if ($global_limit[$id_product] - $product['quantity'] >= $restriction_quantity)
                        {
                            Db::getInstance()->execute('DELETE FROM `' . _DB_PREFIX_ . 'cart_product` WHERE `id_cart` = ' . (int)$params['cart']->id . ' AND `id_product` = ' . (int)$id_product . ' AND `id_product_attribute`=' . $product['id_product_attribute']);
                        }
                        else
                        {
                            if ($global_limit[$id_product] > 1)
                            {
                                $quantity_without_this_product = $global_limit[$id_product] - $product['quantity'];
                                $quantity_expected = $restriction_quantity - $quantity_without_this_product;
                                Db::getInstance()->execute('UPDATE`' . _DB_PREFIX_ . 'cart_product` SET quantity=' . $quantity_expected . ' WHERE `id_cart` = ' . (int)$params['cart']->id . ' AND `id_product` = ' . (int)$id_product . ' AND `id_product_attribute`=' . $product['id_product_attribute']);
                            }
                        }
                    }
                }
            }
        }
    }

    public function cleanUpCartGlobalAspect($params, $restriction_quantity, $id_product, $id_cart)
    {
        if (isset($global_limit[$id_product]))
        {
            unset($global_limit[$id_product]);
        }
        $count = 0;
        $todelete = array();
        $toupdate = array();
        if (method_exists($params['cart'], 'getProducts'))
        {
            $cart = new Cart($params['cart']->id);
            foreach ($cart->getProducts() as $product)
            {
                if ($product['id_product'] == $id_product)
                {
                    $count++;
                    if (!isset($global_limit[$id_product]))
                    {
                        $global_limit[$id_product] = 0;
                    }
                    $global_limit[$id_product] = (int)$global_limit[$id_product] + (int)$product['quantity'];
                    if ($count > $restriction_quantity)
                    {
                        $todelete[$count]['id_product_attribute'] = $product['id_product_attribute'];
                    }
                    else
                    {
                        if ($global_limit[$id_product] > $restriction_quantity)
                        {
                            $toupdate[$count]['id_product_attribute'] = $product['id_product_attribute'];
                            $toupdate[$count]['qty_in_cart'] = (int)$product['quantity'];
                        }
                    }
                }
            }
            $quantity_to_cart = $global_limit[$id_product] - $restriction_quantity;
        }

        if ($global_limit[$id_product] > $restriction_quantity || $count > $restriction_quantity)
        {
            if ($count == 1)
            {
                Db::getInstance()->execute('UPDATE `' . _DB_PREFIX_ . 'cart_product` SET quantity=' . (int)$restriction_quantity . ' WHERE `id_cart` = ' . (int)$params['cart']->id . ' AND `id_product` = ' . (int)$id_product . ' AND `id_product_attribute`=' . $product['id_product_attribute']);
            }
            elseif ($count > $restriction_quantity)
            {
                foreach ($todelete as $nb => $attribute)
                {
                    Db::getInstance()->execute('DELETE FROM `' . _DB_PREFIX_ . 'cart_product` WHERE `id_cart` = ' . (int)$params['cart']->id . ' AND `id_product` = ' . (int)$id_product . ' AND `id_product_attribute`=' . $attribute['id_product_attribute']);
                }
            }
            elseif ($count > 1 && $count <= $restriction_quantity)
            {
                foreach ($toupdate as $nb => $attribute)
                {
                    Db::getInstance()->execute('UPDATE `' . _DB_PREFIX_ . 'cart_product` SET quantity=' . ($attribute['qty_in_cart'] - $quantity_to_cart) . ' WHERE `id_cart` = ' . (int)$params['cart']->id . ' AND `id_product` = ' . (int)$id_product . ' AND `id_product_attribute`=' . $attribute['id_product_attribute']);
                }
            }
        }

        $cart = new Cart($params['cart']->id);
        foreach ($cart->getProducts() as $product)
        {
            if ($product['quantity'] == 0)
            {
                $cart->deleteProduct($product['id_product'], $product['id_product_attribute']);
            }
        }
    }

    public function assignContentVars($params)
    {

    }

    public function getCustomerGroups()
    {
        $customer_groups = array();
        if (isset($this->context->cart->id_customer))
        {
            if ($this->context->cart->id_customer == 0)
            {
                // VISITOR
                $customer_groups[1] = 1;
            }
            else
            {
                // CUSTOMER
                foreach (Customer::getGroupsStatic($this->context->cart->id_customer) as $group)
                {
                    $customer_groups[$group] = 1;
                }
            }
        }
        elseif ($this->context->customer->is_guest == 1)
        {
            $customer_groups[1] = 2;
        }
        else
        {
            // VISITOR
            $customer_groups[1] = 1;
        }
        if (count($customer_groups) > 0)
        {
            return $customer_groups;
        }
        else
        {
            return false;
        }
    }

    private function getCartSummaryURL()
    {
        return $this->context->link->getPageLink('cart', null, $this->context->language->id, array(
            'action' => 'show'
        ), false, null, true);
    }

    public function hookdisplayPaymentTop($params)
    {
        $products_in_cart = array();
        if (isset($this->context->cart->id) && isset($this->context->cart->id_customer))
        {
            foreach ($this->context->cart->getProducts() AS $key => $val)
            {
                if (!isset($products_in_cart[$val['id_product']]))
                {
                    $products_in_cart[$val['id_product']] = 0;
                }
                $products_in_cart[$val['id_product']] = $products_in_cart[$val['id_product']] + $val['quantity'];
            }

            if (count($products_in_cart) > 0)
            {
                $total_qty = array();
                $products = $this->getCustomerOrders();

                foreach ($products AS $p => $v)
                {
                    if (!isset($total_qty[$v['product_id']]))
                    {
                        $total_qty[$v['product_id']] = 0;
                    }
                    $total_qty[$v['product_id']] = $total_qty[$v['product_id']] + $v['product_quantity'];
                }

                $reached_limit = array();
                foreach ($total_qty AS $prdt => $qty)
                {
                    if (isset($products_in_cart[$prdt]))
                    {
                        $limit = 0;
                        $limit_temp = 0;
                        foreach ($this->getCustomerGroups() AS $group => $val)
                        {
                            $limit_temp = MQC::getRestrictionsTotalByGroupValue($prdt, $group);
                            if ($limit_temp >= (isset($limit) ? $limit : 0))
                            {
                                $limit = $limit_temp;
                            }
                        }


                        $qty = ($qty + ((int)(isset($products_in_cart[$prdt]) ? $products_in_cart[$prdt] : 0)));

                        if ($limit != false && isset($products_in_cart[$prdt]))
                        {
                            if ($limit < $qty && isset($products_in_cart[$prdt]))
                            {
                                $reached_limit[$prdt] = $qty;
                            }
                        }
                    }
                }

                foreach ($products_in_cart AS $prdt => $qty)
                {
                    $limit = 0;
                    $limit_temp = 0;
                    foreach ($this->getCustomerGroups() AS $group => $val)
                    {
                        $limit_temp = MQC::getRestrictionsTotalByGroupValue($prdt, $group);
                        if ($limit_temp >= (isset($limit) ? $limit : 0))
                        {
                            $limit = $limit_temp;
                        }
                    }

                    if ($limit != false)
                    {
                        if ($limit < $qty && isset($products_in_cart[$prdt]))
                        {
                            $pr = new Product($prdt, false, $this->context->language->id);
                            $reached_limit[$prdt]['total_qty'] = (isset($total_qty[$prdt]) ? $total_qty[$prdt] : 0);
                            $reached_limit[$prdt]['name'] = $pr->name;
                            $reached_limit[$prdt]['limit'] = $limit;
                            $reached_limit[$prdt]['cart'] = $products_in_cart[$prdt];
                        }
                    }
                }

                if (count($reached_limit) > 0)
                {
                    $ssl = (Configuration::get('PS_SSL_ENABLED') && Configuration::get('PS_SSL_ENABLED_EVERYWHERE'));
                    $base = $ssl ? 'https:' : 'http:';
                    Tools::redirect($base . $this->getCartSummaryURL());
                }
            }
        }
    }

    public function getCustomerOrders()
    {
        $time_frame = Configuration::get('MQC_ORDERSDATE');
        if ($time_frame == 0)
        {
            $sql_time_frame = '';
        }
        elseif ($time_frame == 1)
        {
            $sql_time_frame = "o.date_add >= '" . date("Y-m-d H:i:s", strtotime("-1 year")) . "' AND ";
        }
        elseif ($time_frame == 2)
        {
            $sql_time_frame = "o.date_add >= '" . date("Y-m-d H:i:s", strtotime("-1 month")) . "' AND ";
        }
        elseif ($time_frame == 3)
        {
            $sql_time_frame = "o.date_add >= '" . date("Y-m-d H:i:s", strtotime("-1 week")) . "' AND ";
        }
        elseif ($time_frame == 4)
        {
            $sql_time_frame = "o.date_add >= '" . date("Y-m-d H:i:s", strtotime("-1 day")) . "' AND ";
        }
        elseif ($time_frame == 5)
        {
            $sql_time_frame = "o.date_add >= '" . date("Y".'-1-1') . "' AND ";
        }
        elseif ($time_frame == 6)
        {
            $sql_time_frame = "o.date_add >= '" . date("Y-m-d H:i:s", strtotime("-6 months")) . "' AND ";
        }
        elseif ($time_frame == 7)
        {
            $sql_time_frame = "o.date_add >= '" . date("Y-m-d H:i:s", strtotime("-3 months")) . "' AND ";
        }

        $date_breakpoint = Configuration::get('MQC_DBREAKPOINT');
        if ($date_breakpoint == false || $date_breakpoint == '' || $date_breakpoint == null)
        {
            $sql_date_breakpoint = "o.date_add >= '" . date("Y-m-d H:i:s", strtotime("-50 years")) . "' AND ";
        }
        else
        {
            $sql_date_breakpoint = "o.date_add >= '" . $date_breakpoint . "' AND ";
        }
        return Db::getInstance()->executeS('SELECT product_quantity, product_id FROM ' . _DB_PREFIX_ . 'order_detail od INNER JOIN ' . _DB_PREFIX_ . 'orders o ON o.id_order = od.id_order WHERE 1=1 AND ' . $sql_date_breakpoint . $sql_time_frame . ' o.id_customer = ' . $this->context->cart->id_customer . ' AND o.current_state in (' . (Configuration::get('MQC_ORDERSTATES') != false ? Configuration::get('MQC_ORDERSTATES'):0) . ') ');
    }

    public function hookdisplayShoppingCart($params)
    {
        $products_in_cart = array();
        if (isset($this->context->cart->id) && isset($this->context->cart->id_customer))
        {
            foreach ($this->context->cart->getProducts() AS $key => $val)
            {
                if (!isset($products_in_cart[$val['id_product']]))
                {
                    $products_in_cart[$val['id_product']] = 0;
                }
                $products_in_cart[$val['id_product']] = $products_in_cart[$val['id_product']] + $val['quantity'];
            }

            if (count($products_in_cart) > 0)
            {
                $total_qty = array();
                $products = $this->getCustomerOrders();

                foreach ($products AS $p => $v)
                {
                    if (!isset($total_qty[$v['product_id']]))
                    {
                        $total_qty[$v['product_id']] = 0;
                    }
                    $total_qty[$v['product_id']] = $total_qty[$v['product_id']] + $v['product_quantity'];
                }

                $reached_limit = array();
                foreach ($total_qty AS $prdt => $qty)
                {
                    if (isset($products_in_cart[$prdt]))
                    {
                        $limit = 0;
                        $limit_temp = 0;
                        foreach ($this->getCustomerGroups() AS $group => $val)
                        {
                            $limit_temp = MQC::getRestrictionsTotalByGroupValue($prdt, $group);
                            if ($limit_temp > (isset($limit) ? $limit : 0))
                            {
                                $limit = $limit_temp;
                            }
                        }

                        $qty = ($qty + ((int)(isset($products_in_cart[$prdt]) ? $products_in_cart[$prdt] : 0)));

                        if ($limit != false && isset($products_in_cart[$prdt]))
                        {
                            if ($limit < $qty)
                            {
                                $pr = new Product($prdt, false, $this->context->language->id);
                                $reached_limit[$prdt]['total_qty'] = $total_qty[$prdt];
                                $reached_limit[$prdt]['name'] = $pr->name;
                                $reached_limit[$prdt]['limit'] = $limit;
                                $reached_limit[$prdt]['cart'] = $products_in_cart[$prdt];
                            }
                        }
                    }
                }

                foreach ($products_in_cart AS $prdt => $qty)
                {
                    $limit = 0;
                    $limit_temp = 0;
                    foreach ($this->getCustomerGroups() AS $group => $val)
                    {
                        $limit_temp = MQC::getRestrictionsTotalByGroupValue($prdt, $group);
                        if ($limit_temp >= (isset($limit) ? $limit : 0))
                        {
                            $limit = $limit_temp;
                        }
                    }

                    if ($limit != false)
                    {
                        if ($limit < $qty && isset($products_in_cart[$prdt]))
                        {
                            $pr = new Product($prdt, false, $this->context->language->id);
                            $reached_limit[$prdt]['total_qty'] = (isset($total_qty[$prdt]) ? $total_qty[$prdt] : 0);
                            $reached_limit[$prdt]['name'] = $pr->name;
                            $reached_limit[$prdt]['limit'] = $limit;
                            $reached_limit[$prdt]['cart'] = $products_in_cart[$prdt];
                        }
                    }
                }

                if (count($reached_limit) > 0)
                {
                    $this->context->smarty->assign('reached_limits', $reached_limit);
                    return $this->display(__file__, 'views/templates/hook/shoppingCart.tpl');
                }
            }
        }
    }

    public function hookactionProductUpdate($params)
    {
        $_GET['id_product'] = $params['id_product'];
        if (Tools::isSubmit('saveMqchidden'))
        {
            if (Tools::isSubmit('selectedCombinationMqc'))
            {
                foreach (Tools::getValue('selectedCombinationMqc') as $key => $attr)
                {
                    foreach ($attr as $gr => $value)
                    {
                        $group = $this->getRestrictionsAttributesByGroupAdmin(Tools::getValue('id_product'), $key, $gr);
                        if ($group != false)
                        {
                            if ($value == null || $value == '')
                            {
                                Db::getInstance()->execute('UPDATE `' . _DB_PREFIX_ . 'mqc_attributes` SET quantity=NULL WHERE `id` = ' . (int)$group['id']);
                            }
                            else
                            {
                                Db::getInstance()->execute('UPDATE `' . _DB_PREFIX_ . 'mqc_attributes` SET quantity="' . ($value == "" ? 'NULL' : (int)$value) . '" WHERE `id` = ' . (int)$group['id']);
                            }
                        }
                        else
                        {
                            if ($value != null || $value != '')
                            {
                                Db::getInstance()->execute('INSERT INTO `' . _DB_PREFIX_ . 'mqc_attributes` (`id_attribute`, `id_product`, `group`, `quantity`) VALUES (' . (int)$key . ', ' . (int)Tools::getValue('id_product') . ', ' . (int)$gr . ', ' . ($value == '' ? 'NULL' : (int)$value) . ')');
                            }
                            else
                            {
                                Db::getInstance()->execute('INSERT INTO `' . _DB_PREFIX_ . 'mqc_attributes` (`id_attribute`, `id_product`, `group`, `quantity`) VALUES (' . (int)$key . ', ' . (int)Tools::getValue('id_product') . ', ' . (int)$gr . ',' . 'NULL' . ')');
                            }
                        }
                    }
                }
            }
            if (Tools::isSubmit('selectedGroupsMqc'))
            {
                foreach (Tools::getValue('selectedGroupsMqc') as $key => $value)
                {
                    $group = $this->getRestrictionsByGroupAdmin(Tools::getValue('id_product'), $key);
                    if ($group != false)
                    {
                        if ($value == null || $value == '')
                        {
                            Db::getInstance()->execute('UPDATE `' . _DB_PREFIX_ . 'mqc` SET quantity=NULL WHERE `id` = ' . (int)$group['id']);
                        }
                        else
                        {
                            Db::getInstance()->execute('UPDATE `' . _DB_PREFIX_ . 'mqc` SET quantity="' . ($value == "" ? 'NULL' : (int)$value) . '" WHERE `id` = ' . (int)$group['id']);
                        }
                    }
                    else
                    {
                        if ($value != null || $value != '')
                        {
                            Db::getInstance()->execute('INSERT INTO `' . _DB_PREFIX_ . 'mqc` (`id_product`, `group`, `quantity`) VALUES (' . (int)Tools::getValue("id_product") . ', ' . (int)$key . ', ' . ($value == '' ? 'NULL' : (int)$value) . ')');
                        }
                        else
                        {
                            Db::getInstance()->execute('INSERT INTO `' . _DB_PREFIX_ . 'mqc` (`id_product`, `group`, `quantity`) VALUES (' . (int)Tools::getValue("id_product") . ', ' . (int)$key . ', ' . 'NULL' . ')');
                        }
                    }
                }
            }

            if (Tools::isSubmit('selectedGroupsMqcTotal'))
            {
                foreach (Tools::getValue('selectedGroupsMqcTotal') as $key => $value)
                {
                    $group = $this->getRestrictionsTotalByGroupAdmin(Tools::getValue('id_product'), $key);
                    if ($group != false)
                    {
                        if ($value == null || $value == '')
                        {
                            Db::getInstance()->execute('UPDATE `' . _DB_PREFIX_ . 'mqc_orders` SET quantity=NULL WHERE `id` = ' . (int)$group['id']);
                        }
                        else
                        {
                            Db::getInstance()->execute('UPDATE `' . _DB_PREFIX_ . 'mqc_orders` SET quantity="' . ($value == "" ? 'NULL' : (int)$value) . '" WHERE `id` = ' . (int)$group['id']);
                        }
                    }
                    else
                    {
                        if ($value != null || $value != '')
                        {
                            Db::getInstance()->execute('INSERT INTO `' . _DB_PREFIX_ . 'mqc_orders` (`id_product`, `group`, `quantity`) VALUES (' . (int)Tools::getValue("id_product") . ', ' . (int)$key . ', ' . ($value == '' ? 'NULL' : (int)$value) . ')');
                        }
                        else
                        {
                            Db::getInstance()->execute('INSERT INTO `' . _DB_PREFIX_ . 'mqc_orders` (`id_product`, `group`, `quantity`) VALUES (' . (int)Tools::getValue("id_product") . ', ' . (int)$key . ', ' . 'NULL' . ')');
                        }
                    }
                }
            }
        }
    }

    public function hookdisplayAdminProductsExtra($params)
    {
        $_GET['id_product'] = $params['id_product'];

        $id_product = Tools::getValue('id_product');
        $product = new Product($id_product, true, $this->context->language->id);
        $combination_images = $product->getCombinationImages($this->context->language->id);
        $fpget = $product->getAttributeCombinations($this->context->language->id);
        $combinations = array();
        $matrix_attributes = array();
        foreach ($fpget as $attr)
        {
            $combinations[$attr['id_product_attribute']]['combination'] = $attr;
            if (!isset($combinations[$attr['id_product_attribute']]['combination_name']))
            {
                $combinations[$attr['id_product_attribute']]['combination_name'] = '';
            }
            $combinations[$attr['id_product_attribute']]['combination_name'] = $combinations[$attr['id_product_attribute']]['combination_name'] . $attr['group_name'] . ": " . $attr['attribute_name'] . ", ";
            if (isset($combination_images[$attr['id_product_attribute']]['0']))
            {
                $combinations[$attr['id_product_attribute']]['image'] = $combination_images[$attr['id_product_attribute']]['0'];
            }
            else
            {
                $combinations[$attr['id_product_attribute']]['image'] = 0;
            }
            $gr = new AttributeGroupCore($attr['id_attribute_group']);
            $gr_atr = new Attribute($attr['id_attribute']);
            $combinations[$attr['id_product_attribute']]['attributes'][$gr->position]['name'] = $attr['attribute_name'];
            $combinations[$attr['id_product_attribute']]['attributes'][$gr->position]['type'] = $gr->group_type;
            $combinations[$attr['id_product_attribute']]['attributes'][$gr->position]['color'] = $gr_atr->color;
            $matrix_attributes[$gr->position][$attr['group_name']] = 1;
            ksort($combinations[$attr['id_product_attribute']]['attributes']);
            ksort($matrix_attributes);
        }
        $this->context->smarty->assign('product_attributes', $combinations);
        return $this->display(__file__, 'views/templates/admin/admintab.tpl');
    }

    public function hookHeader()
    {
        $this->context->controller->addCSS(($this->_path) . 'views/css/mqc.css', 'all');
        if (Tools::version_compare(_PS_VERSION_, '1.7.5.0', '>=')) {
            $this->context->controller->addJS(($this->_path) . 'views/js/mqc-17500.js', 'all');
        } else {
            $this->context->controller->addJS(($this->_path) . 'views/js/mqc.js', 'all');
        }
        $this->context->controller->addJqueryPlugin(array('fancybox'));
    }

    public function hookProductActions()
    {
        $restriction_attributes = $this->generateMatrixData(Tools::getValue('id_product'));
        $matrix_attributes = array();
        if (isset($this->context->cart->id_customer))
        {
            // VISTOR
            if ($this->context->cart->id_customer == 0)
            {
                $restriction = $this->getRestrictionsByGroup(Tools::getValue('id_product'), 1);
                foreach ($restriction_attributes AS $cpa => $pa)
                {
                    $matrix_attributes[$cpa] = $this->getRestrictionsAttributesByGroupValue((int)Tools::getValue('id_product'), $cpa, 1);
                }
            }
            else
            {
                // CUSTOMER
                foreach (Customer::getGroupsStatic($this->context->cart->id_customer) as $group)
                {
                    $restriction = $this->getRestrictionsByGroup(Tools::getValue('id_product'), $group);
                }

                foreach ($restriction_attributes AS $cpa => $pa)
                {
                    if (!isset($matrix_attributes[$cpa]))
                    {
                        $matrix_attributes[$cpa] = $this->getRestrictionsAttributesByGroupValue((int)Tools::getValue('id_product'), $cpa, $group);
                    }
                    else
                    {
                        if ($matrix_attributes[$cpa] < $this->getRestrictionsAttributesByGroupValue((int)Tools::getValue('id_product'), $cpa, $group))
                        {
                            $matrix_attributes[$cpa] = $this->getRestrictionsAttributesByGroupValue((int)Tools::getValue('id_product'), $cpa, $group);
                        }
                    }
                }
            }
        }
        elseif ($this->context->customer->is_guest == 1)
        {
            // GUEST
            $restriction = $this->getRestrictionsByGroup(Tools::getValue('id_product'), 2);
            foreach ($restriction_attributes AS $cpa => $pa)
            {
                $matrix_attributes[$cpa] = $this->getRestrictionsAttributesByGroupValue((int)Tools::getValue('id_product'), $cpa, 2);
            }
        }
        else
        {
            //UNKNOW USER
            $restriction = $this->getRestrictionsByGroup(Tools::getValue('id_product'), 1);
            foreach ($restriction_attributes AS $cpa => $pa)
            {
                $matrix_attributes[$cpa] = $this->getRestrictionsAttributesByGroupValue((int)Tools::getValue('id_product'), $cpa, 1);
            }
        }

        if (isset($matrix_attributes))
        {
            foreach ($matrix_attributes AS $key => $value)
            {
                if ($value == null)
                {
                    unset ($matrix_attributes[$key]);
                }
            }
        }
        else
        {
            $matrix_attributes = null;
        }

        if (is_array($matrix_attributes))
        {
            if (count($matrix_attributes) == 0)
            {
                $matrix_attributes = null;
            }
        } else {
            $matrix_attributes = null;
        }

        $this->context->smarty->assign('restriction', $restriction);
        $this->context->smarty->assign('restriction_attributes', $restriction_attributes);
        $this->context->smarty->assign('matrix_qty', $matrix_attributes);
        return $this->display(__file__, 'views/templates/hook/productActions.tpl');
    }

    public function hookactionCartSave($params)
    {

        if (Tools::getValue('summary', 'false') != "false")
        {
            if (Tools::getValue('summary') == 'true')
            {
                $dont_json = 1;
            }
            else
            {
                $dont_json = 0;
            }
        }
        else
        {
            $dont_json = 0;
        }
        $blocked = 0;
        $blocked_attribute = 0;

        if (Tools::getValue('id_product_attribute', 'false') == 'false' && Tools::getValue('id_product', 'false') !='false')
        {
            $_GET['ipa'] = (Tools::getValue('group', 'false') == 'false' ? 0:(int)Product::getIdProductAttributesByIdAttributes(Tools::getValue('id_product'), Tools::getValue('group')));
            $_GET['id_product_attribute'] = $_GET['ipa'];
        }
        else
        {
            $_GET['ipa'] = (isset($_GET['id_product_attribute']) ? $_GET['id_product_attribute']:0);
        }

        if (isset($this->context->cart->id_customer))
        {
            // VISTOR
            if ($this->context->cart->id_customer == 0)
            {
                $restriction = $this->getRestrictionsByGroup(Tools::getValue('id_product'), 1);
                $restriction_attributes = $this->getRestrictionsAttributesByGroup(Tools::getValue('id_product'), (Tools::getValue('ipa', 'false') != 'false' ? Tools::getValue('ipa') : (Tools::getValue('id_product_attribute', 'false') != 'false' ? Tools::getValue('id_product_attribute', 'false') : false)), 1);
                if ($restriction_attributes['quantity'] != null)
                {
                    if ($restriction_attributes != false or $restriction_attributes['quantity'] != '')
                    {
                        if (method_exists($params['cart'], 'getProducts'))
                        {
                            foreach ($params['cart']->getProducts() as $product)
                            {
                                if (isset($restriction_attributes['id_attribute']))
                                {
                                    if (Tools::getValue('id_product') == $product['id_product'] && $restriction_attributes['id_attribute'] == $product['id_product_attribute'])
                                    {
                                        if ($product['quantity'] > $restriction_attributes['quantity'])
                                        {
                                            $blocked_attribute = 1;
                                            $this->errors['atr'] = $this->l('You exceeded maximum allowed quantity for variant of this product:') . '<strong>' . $product['name'] . '</strong>' . ' <strong>' . $this->l('Quantity limit is ') . $restriction_attributes['quantity'] . '</strong>';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                if ($restriction['quantity'] != null)
                {
                    if ($restriction != false or $restriction['quantity'] != '')
                    {
                        if (method_exists($params['cart'], 'getProducts'))
                        {
                            foreach ($params['cart']->getProducts() as $product)
                            {
                                // CALCULATE GLOBAL LIMIT IF ATTRIBUTES EXISTS
                                if ($product['id_product_attribute'] != 0)
                                {
                                    if (!isset($global_limit_attributes[$product['id_product']]))
                                    {
                                        $global_limit_attributes[$product['id_product']] = 0;
                                    }
                                    if (!isset($global_limit_attributes_defined[$product['id_product']][$product['id_product_attribute']]))
                                    {
                                        $global_limit_attributes[$product['id_product']] = $global_limit_attributes[$product['id_product']] + $product['quantity'];
                                        $global_limit_attributes_defined[$product['id_product']][$product['id_product_attribute']] = true;
                                    }
                                }
                                if (Tools::getValue('id_product') == $product['id_product'] && isset($global_limit_attributes[$product['id_product']]))
                                {
                                    if ($global_limit_attributes[$product['id_product']] > $restriction['quantity'])
                                    {
                                        $blocked = 1;
                                        $this->errors['glb'] = $this->l('You exceeded maximum allowed quantity for this product: ') . '<strong>' . $product['name'] . '</strong>' . ' <strong>' . $this->l('Quantity limit is ') . $restriction['quantity'] . '</strong>';
                                    }
                                }

                                // CALCULATE GLOBAL LIMIT WITHOUT ATTRIBUTES
                                if (!isset($global_limit[$product['id_product']]))
                                {
                                    $global_limit[$product['id_product']] = 0;
                                }

                                if (Tools::getValue('id_product') == $product['id_product'] && !isset($global_limit_applied[$product['id_product']]))
                                {
                                    $global_limit[$product['id_product']] = $global_limit[$product['id_product']] + $product['quantity'];
                                    $global_limit_applied[$product['id_product']] = true;
                                    if ($global_limit[$product['id_product']] > $restriction['quantity'])
                                    {
                                        $blocked = 1;
                                        $this->errors['glb'] = $this->l('You exceeded maximum allowed quantity for this product: ') . '<strong>' . $product['name'] . '</strong>' . ' <strong>' . $this->l('Quantity limit is ') . $restriction['quantity'] . '</strong>';
                                    }
                                }
                            }
                        }
                    }
                }
            }
            else
            {
                // CUSTOMER
                $arestriction = array();
                $arestriction_attributes = array();
                foreach (Customer::getGroupsStatic($params['cart']->id_customer) as $group)
                {
                    $arestriction[] = $this->getRestrictionsByGroup(Tools::getValue('id_product'), $group);
                    $arestriction_attributes[] = $this->getRestrictionsAttributesByGroup(Tools::getValue('id_product'), (Tools::getValue('ipa', 'false') != 'false' ? Tools::getValue('ipa') : (Tools::getValue('id_product_attribute', 'false') != 'false' ? Tools::getValue('id_product_attribute', 'false') : false)), $group);
                }


                $restriction['quantity'] = 999999999999;
                foreach ($arestriction AS $key => $value)
                {
                    if (isset($value['quantity']))
                    {
                        if ($value['quantity'] != null && $value['quantity'] != '')
                        {
                            if ($value['quantity'] < $restriction['quantity'])
                            {
                                $restriction['quantity'] = $value['quantity'];
                            }
                        }
                    }
                }

                $restriction_attributes['quantity'] = 999999999999;
                foreach ($arestriction_attributes AS $key => $value)
                {
                    if (isset($value['quantity']))
                    {
                        if ($value['quantity'] != null && $value['quantity'] != '')
                        {
                            if ($value['quantity'] < $restriction_attributes['quantity'])
                            {
                                $restriction_attributes['quantity'] = $value['quantity'];
                                $restriction_attributes['id_attribute'] = $value['id_attribute'];
                            }
                        }
                    }
                }

                if ($restriction_attributes['quantity'] != null)
                {
                    if ($restriction_attributes != false or $restriction_attributes['quantity'] != '')
                    {
                        if (method_exists($params['cart'], 'getProducts'))
                        {
                            foreach ($params['cart']->getProducts() as $product)
                            {
                                if (isset($restriction_attributes['id_attribute']))
                                {
                                    if (Tools::getValue('id_product') == $product['id_product'] && $restriction_attributes['id_attribute'] == $product['id_product_attribute'])
                                    {
                                        if ($product['quantity'] > $restriction_attributes['quantity'])
                                        {
                                            $blocked_attribute = 1;
                                            $this->errors['atr'] = $this->l('You exceeded maximum allowed quantity for variant of this product:') . ' <strong>' . $product['name'] . '</strong>' . ' <strong>' . $this->l('Quantity limit is ') . $restriction_attributes['quantity'] . '</strong>';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                if ($restriction['quantity'] != null)
                {
                    if ($restriction != false or $restriction['quantity'] != '')
                    {
                        if (method_exists($params['cart'], 'getProducts'))
                        {

                            foreach ($params['cart']->getProducts() as $product)
                            {
                                // CALCULATE GLOBAL LIMIT IF ATTRIBUTES EXISTS
                                if ($product['id_product_attribute'] != 0)
                                {
                                    if (!isset($global_limit_attributes[$product['id_product']]))
                                    {
                                        $global_limit_attributes[$product['id_product']] = 0;
                                    }
                                    if (!isset($global_limit_attributes_defined[$product['id_product']][$product['id_product_attribute']]))
                                    {
                                        $global_limit_attributes[$product['id_product']] = $global_limit_attributes[$product['id_product']] + $product['quantity'];
                                        $global_limit_attributes_defined[$product['id_product']][$product['id_product_attribute']] = true;
                                    }
                                }

                                if (Tools::getValue('id_product') == $product['id_product'] && isset($global_limit_attributes[$product['id_product']]))
                                {
                                    if ($global_limit_attributes[$product['id_product']] > $restriction['quantity'])
                                    {
                                        $blocked = 1;
                                        $this->errors['glb'] = $this->l('You exceeded maximum allowed quantity for this product: ') . '<strong>' . $product['name'] . '</strong>' . ' <strong>' . $this->l('Quantity limit is ') . $restriction['quantity'] . '</strong>';
                                    }
                                }

                                // CALCULATE GLOBAL LIMIT WITHOUT ATTRIBUTES
                                if (!isset($global_limit[$product['id_product']]))
                                {
                                    $global_limit[$product['id_product']] = 0;
                                }

                                if (Tools::getValue('id_product') == $product['id_product'] && !isset($global_limit_applied[$product['id_product']]))
                                {
                                    $global_limit[$product['id_product']] = $global_limit[$product['id_product']] + $product['quantity'];
                                    $global_limit_applied[$product['id_product']] = true;
                                    if ($global_limit[$product['id_product']] > $restriction['quantity'])
                                    {
                                        $blocked = 1;
                                        $this->errors['glb'] = $this->l('You exceeded maximum allowed quantity for this product: ') . '<strong>' . $product['name'] . '</strong>' . ' <strong>' . $this->l('Quantity limit is ') . $restriction['quantity'] . '</strong>';
                                    }
                                }
                            }
                        }
                    }
                }
            }
            // GUEST
        }
        elseif ($this->context->customer->is_guest == 1)
        {
            $restriction = $this->getRestrictionsByGroup(Tools::getValue('id_product'), 2);
            $restriction_attributes = $this->getRestrictionsAttributesByGroup(Tools::getValue('id_product'), (Tools::getValue('ipa', 'false') != 'false' ? Tools::getValue('ipa') : (Tools::getValue('id_product_attribute', 'false') != 'false' ? Tools::getValue('id_product_attribute', 'false') : false)), 2);
            $restriction = $this->getRestrictionsByGroup(Tools::getValue('id_product'), 1);
            $restriction_attributes = $this->getRestrictionsAttributesByGroup(Tools::getValue('id_product'), (Tools::getValue('ipa', 'false') != 'false' ? Tools::getValue('ipa') : (Tools::getValue('id_product_attribute', 'false') != 'false' ? Tools::getValue('id_product_attribute', 'false') : false)), 1);
            if ($restriction_attributes['quantity'] != null)
            {
                if ($restriction_attributes != false or $restriction_attributes['quantity'] != '')
                {
                    if (method_exists($params['cart'], 'getProducts'))
                    {
                        foreach ($params['cart']->getProducts() as $product)
                        {
                            if (isset($restriction_attributes['id_attribute']))
                            {
                                if (Tools::getValue('id_product') == $product['id_product'] && $restriction_attributes['id_attribute'] == $product['id_product_attribute'])
                                {
                                    if ($product['quantity'] > $restriction_attributes['quantity'])
                                    {
                                        $blocked_attribute = 1;
                                        $this->errors['atr'] = $this->l('You exceeded maximum allowed quantity for variant of this product:') . '<strong>' . $product['name'] . '</strong>' . ' <strong>' . $this->l('Quantity limit is ') . $restriction_attributes['quantity'] . '</strong>';
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if ($restriction['quantity'] != null)
            {
                if ($restriction != false or $restriction['quantity'] != '')
                {
                    if (method_exists($params['cart'], 'getProducts'))
                    {
                        foreach ($params['cart']->getProducts() as $product)
                        {
                            // CALCULATE GLOBAL LIMIT IF ATTRIBUTES EXISTS
                            if ($product['id_product_attribute'] != 0)
                            {
                                if (!isset($global_limit_attributes[$product['id_product']]))
                                {
                                    $global_limit_attributes[$product['id_product']] = 0;
                                }
                                if (!isset($global_limit_attributes_defined[$product['id_product']][$product['id_product_attribute']]))
                                {
                                    $global_limit_attributes[$product['id_product']] = $global_limit_attributes[$product['id_product']] + $product['quantity'];
                                    $global_limit_attributes_defined[$product['id_product']][$product['id_product_attribute']] = true;
                                }
                            }
                            if (Tools::getValue('id_product') == $product['id_product'] && isset($global_limit_attributes[$product['id_product']]))
                            {
                                if ($global_limit_attributes[$product['id_product']] > $restriction['quantity'])
                                {
                                    $blocked = 1;
                                    $this->errors['glb'] = $this->l('You exceeded maximum allowed quantity for this product: ') . '<strong>' . $product['name'] . '</strong>' . ' <strong>' . $this->l('Quantity limit is ') . $restriction['quantity'] . '</strong>';
                                }
                            }

                            // CALCULATE GLOBAL LIMIT WITHOUT ATTRIBUTES
                            if (!isset($global_limit[$product['id_product']]))
                            {
                                $global_limit[$product['id_product']] = 0;
                            }

                            if (Tools::getValue('id_product') == $product['id_product'] && !isset($global_limit_applied[$product['id_product']]))
                            {
                                $global_limit[$product['id_product']] = $global_limit[$product['id_product']] + $product['quantity'];
                                $global_limit_applied[$product['id_product']] = true;
                                if ($global_limit[$product['id_product']] > $restriction['quantity'])
                                {
                                    $blocked = 1;
                                    $this->errors['glb'] = $this->l('You exceeded maximum allowed quantity for this product: ') . ' <strong>' . $product['name'] . '</strong>' . ' <strong>' . $this->l('Quantity limit is ') . $restriction['quantity'] . '</strong>';
                                }
                            }
                        }
                    }
                }
            }
        }
        else
        {
            //zupelnie obcy
            $restriction = $this->getRestrictionsByGroup(Tools::getValue('id_product'), 1);
            $restriction_attributes = $this->getRestrictionsAttributesByGroup(Tools::getValue('id_product'), (Tools::getValue('ipa', 'false') != 'false' ? Tools::getValue('ipa') : (Tools::getValue('id_product_attribute', 'false') != 'false' ? Tools::getValue('id_product_attribute', 'false') : false)), 1);

            if ($restriction_attributes['quantity'] != null)
            {
                if ($restriction_attributes != false or $restriction_attributes['quantity'] != '')
                {

                    if (method_exists($params['cart'], 'getProducts'))
                    {
                        foreach ($params['cart']->getProducts() as $product)
                        {
                            if (isset($restriction_attributes['id_attribute']))
                            {
                                if (Tools::getValue('id_product') == $product['id_product'] && $restriction_attributes['id_attribute'] == $product['id_product_attribute'])
                                {
                                    if ($product['quantity'] > $restriction_attributes['quantity'])
                                    {
                                        $blocked_attribute = 1;
                                        $this->errors['atr'] = $this->l('You exceeded maximum allowed quantity for variant of this product: ') . '<strong>' . $product['name'] . '</strong>' . ' <strong>' . $this->l('Quantity limit is ') . $restriction_attributes['quantity'] . '</strong>';
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if ($restriction['quantity'] != null)
            {
                if ($restriction != false or $restriction['quantity'] != '')
                {
                    if (method_exists($params['cart'], 'getProducts'))
                    {
                        foreach ($params['cart']->getProducts() as $product)
                        {
                            // CALCULATE GLOBAL LIMIT IF ATTRIBUTES EXISTS
                            if ($product['id_product_attribute'] != 0)
                            {
                                if (!isset($global_limit_attributes[$product['id_product']]))
                                {
                                    $global_limit_attributes[$product['id_product']] = 0;
                                }
                                if (!isset($global_limit_attributes_defined[$product['id_product']][$product['id_product_attribute']]))
                                {
                                    $global_limit_attributes[$product['id_product']] = $global_limit_attributes[$product['id_product']] + $product['quantity'];
                                    $global_limit_attributes_defined[$product['id_product']][$product['id_product_attribute']] = true;
                                }
                            }
                            if (Tools::getValue('id_product') == $product['id_product'] && isset($global_limit_attributes[$product['id_product']]))
                            {
                                if ($global_limit_attributes[$product['id_product']] > $restriction['quantity'])
                                {
                                    $blocked = 1;
                                    $this->errors['glb'] = $this->l('You exceeded maximum allowed quantity for this product: ') . '<strong>' . $product['name'] . '</strong>' . ' <strong>' . $this->l('Quantity limit is ') . $restriction['quantity'] . '</strong>';
                                }
                            }

                            // CALCULATE GLOBAL LIMIT WITHOUT ATTRIBUTES
                            if (!isset($global_limit[$product['id_product']]))
                            {
                                $global_limit[$product['id_product']] = 0;
                            }

                            if (Tools::getValue('id_product') == $product['id_product'] && !isset($global_limit_applied[$product['id_product']]))
                            {
                                $global_limit[$product['id_product']] = $global_limit[$product['id_product']] + $product['quantity'];
                                $global_limit_applied[$product['id_product']] = true;
                                if ($global_limit[$product['id_product']] > $restriction['quantity'])
                                {
                                    $blocked = 1;
                                    $this->errors['glb'] = $this->l('You exceeded maximum allowed quantity for this product: ') . '<strong>' . $product['name'] . '</strong>' . ' <strong>' . $this->l('Quantity limit is ') . $restriction['quantity'] . '</strong>';
                                }
                            }
                        }
                    }
                }
            }
        }


        $show_die = 0;
        $show_die_attribute = 0;

        if ($blocked_attribute == 1)
        {
            $this->cleanUpAttributesCartGlobalAspect($params, $restriction_attributes['quantity'], Tools::getValue('id_product'), Tools::getValue('ipa'), $params['cart']->id);
            $show_die_attribute = 1;
        }

        if ($blocked == 1)
        {
            $this->cleanUpCartGlobalAspect($params, (int)$restriction['quantity'], (int)Tools::getValue('id_product'), (int)$params['cart']->id);
            $show_die = 1;
        }

        if (Tools::getValue('delete', 'false') == 'false' && ($show_die == 1 || $show_die_attribute == 1))
        {
            if (Tools::getValue('op') == 'up')
            {
                if (Tools::getValue('qty', 'false') != 'false')
                {
                    $quantity_added = Tools::getValue('qty');
                }
                else
                {
                    $quantity_added = 1;
                }
            }
            elseif (Tools::getValue('op', 'down'))
            {
                if (Tools::getValue('qty', 'false') != 'false')
                {
                    $quantity_added = Tools::getValue('qty');
                }
                else
                {
                    $quantity_added = 0;
                }
            }

            $cart = new Cart($params['cart']->id);
            foreach ($cart->getProducts() as $product)
            {
                $product_qty_original[$product['id_product']][$product['id_product_attribute']] = $product['quantity'];
            }

            if (version_compare(_PS_VERSION_, '1.7.3.0', '>='))
            {
                if (in_array(Tools::getValue('op'), array('up','down')))
                {
                    $this->errors = implode(',', $this->errors);
                } 
                else 
                {
                    foreach ($this->errors AS $key => $error)
                    {
                        $this->errors[$key] = $error;
                    }
                }    
            } 
            else 
            {
               foreach ($this->errors AS $key => $error)
               {
               $this->errors[$key] = $error;
               } 
            }

            die(Tools::jsonEncode([
                'hasError' => true,
                'success' => false,
                'linkAction' => 'test',
                'errors' => $this->errors,
                'id_product' => Tools::getValue('id_product'),
                'id_product_attribute' => Tools::getValue('ipa'),
                'quantity' => (isset($product_qty_original[Tools::getValue('id_product')][Tools::getValue('ipa')]) ? (int)$product_qty_original[Tools::getValue('id_product')][Tools::getValue('ipa')] : '')
            ]));

        }
    }

    public function hookactionAuthentication($params)
    {
        if (isset($params['customer']->id))
        {
            foreach (Customer::getGroupsStatic($params['cart']->id_customer) as $group)
            {
                if (method_exists($params['cart'], 'getProducts'))
                {
                    foreach ($params['cart']->getProducts() as $product)
                    {
                        if (isset($product['id_product_attribute']))
                        {
                            if ($product['id_product_attribute'] != 0)
                            {
                                $restriction_attribute = $this->getRestrictionsAttributesByGroup($product['id_product'], $product['id_product_attribute'], $group);
                                if ($restriction_attribute)
                                {
                                    $this->cleanUpAttributesCartGlobalAspect($params, $restriction_attribute['quantity'], $product['id_product'], $product['id_product_attribute'], $params['cart']->id);
                                }
                            }
                            $restriction = $this->getRestrictionsByGroup($product['id_product'], $group);
                            if ($restriction)
                            {
                                $this->cleanUpNewCartGlobalAspect($params, $restriction['quantity'], $product['id_product'], $group);
                            }
                        }
                    }
                }
            }
        }
    }

    public function renderFormMainSettings()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Main settings ') . ' ' . $this->l('Global configuration of the module'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'radio',
                        'class' => 't',
                        'label' => $this->l('Control quantity field value'),
                        'name' => 'MQC_CONTROL_QTY',
                        'desc' => $this->l('This option when active will block possibility to increase quantity field (on product page) value to value higher than allowed maximum product\'s quantity defined with this module'),
                        'values' => array(
                            array(
                                'id' => 'a_active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'a_active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            )
        );

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->id = 'MQC_MAIN_SETTINGS';
        $helper->identifier = 'MQC_MAIN_SETTINGS';
        $helper->submit_action = 'btnSubmit';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );
        return $helper->generateForm(array($fields_form));
    }

    public function renderForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Cart conditions: ') . ' ' . $this->l('Global configuration of the module'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'radio',
                        'class' => 't',
                        'label' => $this->l('Global limit for each product'),
                        'name' => 'MQC_GL',
                        'desc' => $this->l('Enable this option if you want to create maximum quantity limit for each product in your shop. Module will use value of maximum quantity defined below. Please note that even with this option each product can have own unique settings (you can define them on module configuration page)'),
                        'values' => array(
                            array(
                                'id' => 'a_active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'a_active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Global maximum quantity value'),
                        'name' => 'MQC_GLV',
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            )
        );

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->id = (int)Tools::getValue('id_carrier');
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'btnSubmit';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );
        return $helper->generateForm(array($fields_form));
    }

    public function renderFormStates()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('All orders conditions: Set order states'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'html',
                        'label' => $this->l('Select order states'),
                        'name' => 'MQC_ORDERSTATES',
                        'html_content' => $this->renderFormOrderStates(),
                    ),
                    array(
                        'type' => 'datetime',
                        'label' => $this->l('Date brakpoint'),
                        'desc' => $this->l('Module will not count the number of product purchases from orders placed BEFORE this date.') . ' ' . $this->l('If you don\'t want such restriction just set it for some old times, for example to 1960s'),
                        'name' => 'MQC_DBREAKPOINT',
                        'required' => true,
                    ),
                    array(
                        'type' => 'radio',
                        'class' => 't',
                        'label' => $this->l('Time frame'),
                        'name' => 'MQC_ORDERSDATE',
                        'desc' => $this->l('To calculate how many products customer bought module will use orders from defined time frame.'),
                        'values' => array(
                            array(
                                'id' => 'mqc_ordersdate_0',
                                'value' => 0,
                                'label' => $this->l('All orders')
                            ),
                            array(
                                'id' => 'mqc_ordersdate_5',
                                'value' => 5,
                                'label' => $this->l('This year orders (from 1 Jan this year)')
                            ),
                            array(
                                'id' => 'mqc_ordersdate_1',
                                'value' => 1,
                                'label' => $this->l('Last year orders')
                            ),
                            array(
                                'id' => 'mqc_ordersdate_6',
                                'value' => 6,
                                'label' => $this->l('Last 6 months orders')
                            ),
                            array(
                                'id' => 'mqc_ordersdate_6',
                                'value' => 7,
                                'label' => $this->l('Last 3 months orders')
                            ),
                            array(
                                'id' => 'mqc_ordersdate_2',
                                'value' => 2,
                                'label' => $this->l('Last month orders')
                            ),
                            array(
                                'id' => 'mqc_ordersdate_2',
                                'value' => 3,
                                'label' => $this->l('Last week orders')
                            ),
                            array(
                                'id' => 'mqc_ordersdate_4',
                                'value' => 4,
                                'label' => $this->l('Last day orders')
                            )
                        ),
                    )
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            )
        );

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->id = 'id_mqc_ostates';
        $helper->identifier = 'mqc_ostates';
        $helper->submit_action = 'btnSubmit_ostates';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );
        return $helper->generateForm(array($fields_form));

    }

    public function renderFormOrderStates()
    {
        $explode_states = explode(',', Configuration::get('MQC_ORDERSTATES'));
        $this->context->smarty->assign('MQC_ORDERSTATES', $explode_states);
        $this->context->smarty->assign('orderStates', OrderState::getOrderStates($this->context->language->id));
        return $this->display(__file__, 'views/templates/admin/orderstates.tpl');
    }

    public function getContent()
    {
        $this->_postProcess();
        $this->context->smarty->assign('mqc_global_main_settings', $this->renderFormMainSettings());
        $this->context->smarty->assign('mqc_global_form', $this->display(__file__, 'views/templates/admin/message2.tpl') . $this->renderForm());
        $this->context->smarty->assign('mqc_mass_mqc', $this->display(__file__, 'views/templates/admin/message3.tpl') . $this->generateFormMassMqc());
        $this->context->smarty->assign('mqc_orders_mqc', $this->display(__file__, 'views/templates/admin/message.tpl') . $this->renderFormStates());
        $this->context->smarty->assign('mqc_orders_mqc_orders', $this->display(__file__, 'views/templates/admin/message4.tpl') . $this->generateFormMassMqcOrders());
        return $this->display(__file__, 'views/templates/admin/main.tpl') . $this->checkforupdates(0,1);
    }

    public function generateFormMassMqc()
    {
        $root = Category::getRootCategory();
        if (Tools::version_compare(_PS_VERSION_, '1.6.0.0', '>='))
        {
            $tree = new HelperTreeCategories('mqc-categories-tree', $this->l('Categories'));
            $tree->setRootCategory($root->id);
            $tree->setUseCheckBox(true);
            $tree->setUseSearch(true);
            $category_tree = $tree->render();
        }
        else
        {
            $tree = new Helper();
            $category_tree = $tree->renderCategoryTree(null, array(), 'categoryBox[]', true, true, array(), false, false);
        }

        $options_wtd = array(
            array(
                'id_option' => '1',
                'name' => $this->l('Define maximum quantity for products')
            ),
            array(
                'id_option' => '2',
                'name' => $this->l('Define maximum quantity for products\' attributes')
            ),
            array(
                'id_option' => '3',
                'name' => $this->l('Remove defined maximum quantities for products')
            ),
            array(
                'id_option' => '4',
                'name' => $this->l('Remove defined maximum quantities for products\' attributes')
            )
        );

        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Cart conditions: ') . ' ' . $this->l('Mass define / remove quantity limits by categories'),
                    'icon' => 'icon-wrench'
                ),
                'input' => array(
                    array(
                        'type' => 'html',
                        'label' => $this->l('Select categories'),
                        'name' => 'MQC_CATEGORIES',
                        'html_content' => $category_tree,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('What you want to do?'),
                        'name' => 'MQC_WTD',
                        'desc' => $this->l('Select one action that you want to with products from selected categories'),
                        'options' => array(
                            'query' => $options_wtd,
                            'id' => 'id_option',
                            'name' => 'name'
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Target Group of customers'),
                        'name' => 'MQC_GROUPS',
                        'desc' => $this->l('You can define / remove defined maximum quantities for selected group of customers only'),
                        'options' => array(
                            'query' => Group::getGroups($this->context->language->id),
                            'id' => 'id_group',
                            'name' => 'name'
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Quantity to define'),
                        'name' => 'MQC_QTY',
                        'desc' => $this->l('If you want to define maximum quantity restrictions just set the value here (numbers only)'),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            ),
        );

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->id = 'MQC_SETTINGS';
        $helper->identifier = 'identifier_MQC_MASS';
        $helper->submit_action = 'submit_MQC_MASS';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );
        return $helper->generateForm(array($fields_form));
    }

    public function generateFormMassMqcOrders()
    {
        $root = Category::getRootCategory();
        if (Tools::version_compare(_PS_VERSION_, '1.6.0.0', '>='))
        {
            $tree = new HelperTreeCategories('mqc-categories-tree-orders', $this->l('Categories'));
            $tree->setRootCategory($root->id);
            $tree->setUseCheckBox(true);
            $tree->setUseSearch(true);
            $category_tree = $tree->render();
        }
        else
        {
            $tree = new Helper();
            $category_tree = $tree->renderCategoryTree(null, array(), 'categoryBoxOrders[]', true, true, array(), false, false);
        }

        $options_wtd = array(
            array(
                'id_option' => '1',
                'name' => $this->l('Define maximum quantity for products')
            ),
            array(
                'id_option' => '3',
                'name' => $this->l('Remove defined maximum quantities for products')
            ),
        );

        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('ALL ORDERS CONDITIONS: ') . ' ' . $this->l('Mass define / remove quantity limits by categories'),
                    'icon' => 'icon-wrench'
                ),
                'input' => array(
                    array(
                        'type' => 'html',
                        'label' => $this->l('Select categories'),
                        'name' => 'MQC_CATEGORIES',
                        'html_content' => $category_tree,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('What you want to do?'),
                        'name' => 'MQC_WTD',
                        'desc' => $this->l('Select one action that you want to with products from selected categories'),
                        'options' => array(
                            'query' => $options_wtd,
                            'id' => 'id_option',
                            'name' => 'name'
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Target Group of customers'),
                        'name' => 'MQC_GROUPS',
                        'desc' => $this->l('You can define / remove defined maximum quantities for selected group of customers only'),
                        'options' => array(
                            'query' => Group::getGroups($this->context->language->id),
                            'id' => 'id_group',
                            'name' => 'name'
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Quantity to define'),
                        'name' => 'MQC_QTY',
                        'desc' => $this->l('If you want to define maximum quantity restrictions just set the value here (numbers only)'),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            ),
        );

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->id = 'MQC_MASS_ORDERS';
        $helper->identifier = 'identifier_MQC_MASS_ORDERS';
        $helper->submit_action = 'submit_MQC_MASS_ORDERS';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );
        return $helper->generateForm(array($fields_form));
    }

    public function getConfigFieldsValues()
    {
        return array(
            'MQC_CONTROL_QTY' => Tools::getValue('MQC_CONTROL_QTY', Configuration::get('MQC_CONTROL_QTY')),
            'MQC_GL' => Tools::getValue('MQC_GL', Configuration::get('MQC_GL')),
            'MQC_GLV' => Tools::getValue('MQC_GLV', Configuration::get('MQC_GLV')),
            'MQC_DBREAKPOINT' => Tools::getValue('MQC_DBREAKPOINT', Configuration::get('MQC_DBREAKPOINT')),
            'MQC_CATEGORIES' => '',
            'MQC_WTD' => '',
            'MQC_GROUPS' => '',
            'MQC_QTY' => '',
            'MQC_ORDERSDATE' => Configuration::get('MQC_ORDERSDATE'),
        );
    }

    public function _postProcess()
    {
        if (Tools::isSubmit('btnSubmit'))
        {
            Configuration::updateValue('MQC_GL', Tools::getValue('MQC_GL'));
            Configuration::updateValue('MQC_GLV', Tools::getValue('MQC_GLV'));
            $this->context->controller->confirmations[] = $this->l('Settings saved properly');
        }

        if (Tools::isSubmit('MQC_CONTROL_QTY'))
        {
            Configuration::updateValue('MQC_CONTROL_QTY', Tools::getValue('MQC_CONTROL_QTY'));
            $this->context->controller->confirmations[] = $this->l('Settings saved properly');
        }

        if (Tools::isSubmit('btnSubmit_ostates'))
        {
            Configuration::updateValue('MQC_ORDERSTATES', implode(",", Tools::getValue('MQC_ORDERSTATES')));
            Configuration::updateValue('MQC_ORDERSDATE', Tools::getValue('MQC_ORDERSDATE'));
            Configuration::updateValue('MQC_DBREAKPOINT', Tools::getValue('MQC_DBREAKPOINT'));
            $this->context->controller->confirmations[] = $this->l('Settings saved properly');
        }

        if (Tools::isSubmit('submit_MQC_MASS'))
        {
            $products_array = array();
            foreach (Tools::getValue('categoryBox') AS $catid)
            {
                $products = Db::getInstance()->executeS('SELECT * FROM `' . _DB_PREFIX_ . 'category_product` WHERE id_category=' . (int)$catid . ' ');
                if ($products)
                {
                    foreach ($products AS $product)
                    {
                        $products_array[$product['id_product']] = $product['id_product'];
                    }
                }
            }

            if (is_array($products_array))
            {
                if (count($products_array) <= 0)
                {
                    return;
                }
            }

            if (Tools::getValue('MQC_WTD') == 1)
            {
                foreach ($products_array AS $pid)
                {
                    $value = Tools::getValue('MQC_QTY', null);
                    $group = $this->getRestrictionsByGroupAdmin($pid, Tools::getValue('MQC_GROUPS'));
                    if ($group != false)
                    {
                        if ($value == null || $value == '')
                        {
                            Db::getInstance()->execute('UPDATE `' . _DB_PREFIX_ . 'mqc` SET quantity=NULL WHERE `id` = ' . (int)$group['id']);
                        }
                        else
                        {
                            Db::getInstance()->execute('UPDATE `' . _DB_PREFIX_ . 'mqc` SET quantity="' . ($value == "" ? 'NULL' : (int)$value) . '" WHERE `id` = ' . (int)$group['id']);
                        }
                    }
                    else
                    {
                        if ($value != null || $value != '')
                        {
                            Db::getInstance()->execute('INSERT INTO `' . _DB_PREFIX_ . 'mqc` (`id_product`, `group`, `quantity`) VALUES (' . (int)$pid . ', ' . (int)Tools::getValue('MQC_GROUPS') . ', ' . ($value == '' ? 'NULL' : (int)$value) . ')');
                        }
                        else
                        {
                            Db::getInstance()->execute('INSERT INTO `' . _DB_PREFIX_ . 'mqc` (`id_product`, `group`, `quantity`) VALUES (' . (int)$pid . ', ' . (int)Tools::getValue('MQC_GROUPS') . ', ' . 'NULL' . ')');
                        }
                    }
                }
                $this->context->controller->confirmations[] = $this->l('Quantity limits added to database');
            }
            elseif (Tools::getValue('MQC_WTD') == 2)
            {
                foreach ($products_array AS $pid)
                {

                    $value = Tools::getValue('MQC_QTY', null);
                    $group = $this->getRestrictionsByGroupAdmin($pid, Tools::getValue('MQC_GROUPS'));
                    $id_product = $pid;
                    $product = new Product($id_product, true, $this->context->language->id);
                    $combination_images = $product->getCombinationImages($this->context->language->id);
                    $fpget = $product->getAttributeCombinations($this->context->language->id);
                    $combinations = array();
                    $matrix_attributes = array();
                    foreach ($fpget as $attr)
                    {
                        $combinations[$attr['id_product_attribute']]['combination'] = $attr;
                        if (!isset($combinations[$attr['id_product_attribute']]['combination_name']))
                        {
                            $combinations[$attr['id_product_attribute']]['combination_name'] = '';
                        }
                        $combinations[$attr['id_product_attribute']]['combination_name'] = $combinations[$attr['id_product_attribute']]['combination_name'] . $attr['group_name'] . ": " . $attr['attribute_name'] . ", ";
                        if (isset($combination_images[$attr['id_product_attribute']]['0']))
                        {
                            $combinations[$attr['id_product_attribute']]['image'] = $combination_images[$attr['id_product_attribute']]['0'];
                        }
                        else
                        {
                            $combinations[$attr['id_product_attribute']]['image'] = 0;
                        }
                        $gr = new AttributeGroupCore($attr['id_attribute_group']);
                        $gr_atr = new Attribute($attr['id_attribute']);
                        $combinations[$attr['id_product_attribute']]['attributes'][$gr->position]['name'] = $attr['attribute_name'];
                        $combinations[$attr['id_product_attribute']]['attributes'][$gr->position]['type'] = $gr->group_type;
                        $combinations[$attr['id_product_attribute']]['attributes'][$gr->position]['color'] = $gr_atr->color;
                        $matrix_attributes[$gr->position][$attr['group_name']] = 1;
                        ksort($combinations[$attr['id_product_attribute']]['attributes']);
                        ksort($matrix_attributes);
                    }

                    foreach ($combinations as $gr => $valuee)
                    {
                        $group = $this->getRestrictionsAttributesByGroupAdmin($pid, $gr, Tools::getValue('MQC_GROUPS'));
                        if ($group != false)
                        {
                            if ($value == null || $value == '')
                            {
                                Db::getInstance()->execute('UPDATE `' . _DB_PREFIX_ . 'mqc_attributes` SET quantity=NULL WHERE `id` = ' . (int)$group['id']);
                            }
                            else
                            {
                                Db::getInstance()->execute('UPDATE `' . _DB_PREFIX_ . 'mqc_attributes` SET quantity="' . ($value == "" ? 'NULL' : (int)$value) . '" WHERE `id` = ' . (int)$group['id']);
                            }
                        }
                        else
                        {
                            if ($value != null || $value != '')
                            {
                                Db::getInstance()->execute('INSERT INTO `' . _DB_PREFIX_ . 'mqc_attributes` (`id_attribute`, `id_product`, `group`, `quantity`) VALUES (' . (int)$gr . ', ' . (int)$id_product . ', ' . (int)Tools::getValue('MQC_GROUPS') . ', ' . ($value == '' ? 'NULL' : (int)$value) . ')');
                            }
                            else
                            {
                                Db::getInstance()->execute('INSERT INTO `' . _DB_PREFIX_ . 'mqc_attributes` (`id_attribute`, `id_product`, `group`, `quantity`) VALUES (' . (int)$gr . ', ' . (int)$id_product . ', ' . (int)Tools::getValue('MQC_GROUPS') . ',' . 'NULL' . ')');
                            }
                        }
                    }
                }
                $this->context->controller->confirmations[] = $this->l('Quantity limits added to database');
            }
            elseif (Tools::getValue('MQC_WTD') == 3)
            {
                foreach ($products_array AS $pid)
                {
                    if (Db::getInstance()->execute('UPDATE `' . _DB_PREFIX_ . 'mqc` SET quantity = NULL WHERE id_product = "' . (int)$pid . '" AND `group` = "' . (int)Tools::getValue('MQC_GROUPS') . '"'))
                    {
                        $this->context->controller->confirmations[] = $this->l('Removed maximum quantity limits properly');
                    }
                    else
                    {
                        $this->context->controller->warnings[] = $this->l('There was a problem with removing the quantities or products from selected categories had no limits');
                    }
                }
            }
            elseif (Tools::getValue('MQC_WTD') == 4)
            {
                foreach ($products_array AS $pid)
                {
                    $value = Tools::getValue('MQC_QTY', null);
                    $group = $this->getRestrictionsByGroupAdmin($pid, Tools::getValue('MQC_GROUPS'));
                    $id_product = $pid;
                    $product = new Product($id_product, true, $this->context->language->id);
                    $combination_images = $product->getCombinationImages($this->context->language->id);
                    $fpget = $product->getAttributeCombinations($this->context->language->id);
                    $combinations = array();
                    $matrix_attributes = array();
                    foreach ($fpget as $attr)
                    {
                        $combinations[$attr['id_product_attribute']]['combination'] = $attr;
                        if (!isset($combinations[$attr['id_product_attribute']]['combination_name']))
                        {
                            $combinations[$attr['id_product_attribute']]['combination_name'] = '';
                        }
                        $combinations[$attr['id_product_attribute']]['combination_name'] = $combinations[$attr['id_product_attribute']]['combination_name'] . $attr['group_name'] . ": " . $attr['attribute_name'] . ", ";
                        if (isset($combination_images[$attr['id_product_attribute']]['0']))
                        {
                            $combinations[$attr['id_product_attribute']]['image'] = $combination_images[$attr['id_product_attribute']]['0'];
                        }
                        else
                        {
                            $combinations[$attr['id_product_attribute']]['image'] = 0;
                        }
                        $gr = new AttributeGroupCore($attr['id_attribute_group']);
                        $gr_atr = new Attribute($attr['id_attribute']);
                        $combinations[$attr['id_product_attribute']]['attributes'][$gr->position]['name'] = $attr['attribute_name'];
                        $combinations[$attr['id_product_attribute']]['attributes'][$gr->position]['type'] = $gr->group_type;
                        $combinations[$attr['id_product_attribute']]['attributes'][$gr->position]['color'] = $gr_atr->color;
                        $matrix_attributes[$gr->position][$attr['group_name']] = 1;
                        ksort($combinations[$attr['id_product_attribute']]['attributes']);
                        ksort($matrix_attributes);
                    }

                    foreach ($combinations as $gr => $valuee)
                    {
                        $group = $this->getRestrictionsAttributesByGroupAdmin($pid, $gr, Tools::getValue('MQC_GROUPS'));
                        if (Db::getInstance()->execute('UPDATE `' . _DB_PREFIX_ . 'mqc_attributes` SET quantity = NULL WHERE `id_attribute` = "' . (int)$gr . '" AND `id_product` = "' . (int)$id_product . '" AND `group` = "' . (int)Tools::getValue('MQC_GROUPS') . '"'))
                        {
                            $this->context->controller->confirmations[] = $this->l('Removed maximum quantity limits properly');
                        }
                        else
                        {
                            $this->context->controller->warnings[] = $this->l('There was a problem with removing the quantities or products from selected categories had no limits');
                        }
                    }
                }
            }
        }

        if (Tools::isSubmit('submit_MQC_MASS_ORDERS'))
        {
            $products_array = array();
            foreach (Tools::getValue('categoryBox') AS $catid)
            {
                $products = Db::getInstance()->executeS('SELECT * FROM `' . _DB_PREFIX_ . 'category_product` WHERE id_category=' . (int)$catid . ' ');
                if ($products)
                {
                    foreach ($products AS $product)
                    {
                        $products_array[$product['id_product']] = $product['id_product'];
                    }
                }
            }

            if (count($products_array) <= 0)
            {
                return;
            }

            if (Tools::getValue('MQC_WTD') == 1)
            {
                foreach ($products_array AS $pid)
                {
                    $value = Tools::getValue('MQC_QTY', null);
                    $group = MQC::getRestrictionsTotalByGroupAdmin($pid, Tools::getValue('MQC_GROUPS'));
                    if ($group != false)
                    {
                        if ($value == null || $value == '')
                        {
                            Db::getInstance()->execute('UPDATE `' . _DB_PREFIX_ . 'mqc_orders` SET quantity=NULL WHERE `id` = ' . (int)$group['id']);
                        }
                        else
                        {
                            Db::getInstance()->execute('UPDATE `' . _DB_PREFIX_ . 'mqc_orders` SET quantity="' . ($value == "" ? 'NULL' : (int)$value) . '" WHERE `id` = ' . (int)$group['id']);
                        }
                    }
                    else
                    {
                        if ($value != null || $value != '')
                        {
                            Db::getInstance()->execute('INSERT INTO `' . _DB_PREFIX_ . 'mqc_orders` (`id_product`, `group`, `quantity`) VALUES (' . (int)$pid . ', ' . (int)Tools::getValue('MQC_GROUPS') . ', ' . ($value == '' ? 'NULL' : (int)$value) . ')');
                        }
                        else
                        {
                            Db::getInstance()->execute('INSERT INTO `' . _DB_PREFIX_ . 'mqc_orders` (`id_product`, `group`, `quantity`) VALUES (' . (int)$pid . ', ' . (int)Tools::getValue('MQC_GROUPS') . ', ' . 'NULL' . ')');
                        }
                    }
                }
                $this->context->controller->confirmations[] = $this->l('Quantity limits added to database');
            }
            elseif (Tools::getValue('MQC_WTD') == 3)
            {
                foreach ($products_array AS $pid)
                {
                    if (Db::getInstance()->execute('UPDATE `' . _DB_PREFIX_ . 'mqc_orders` SET quantity = NULL WHERE id_product = "' . (int)$pid . '" AND `group` = "' . (int)Tools::getValue('MQC_GROUPS') . '"'))
                    {
                        $this->context->controller->confirmations[] = $this->l('Removed maximum quantity limits properly');
                    }
                    else
                    {
                        $this->context->controller->warnings[] = $this->l('There was a problem with removing the quantities or products from selected categories had no limits');
                    }
                }
            }
        }
    }

    public function generateMatrixData($id_product)
    {
        $product = new Product($id_product, true, $this->context->language->id);
        $combination_images = $product->getCombinationImages($this->context->language->id);
        $fpget = $product->getAttributeCombinations($this->context->language->id);
        $combinations = array();
        $matrix_attributes = array();
        foreach ($fpget as $attr)
        {
            $combinations[$attr['id_product_attribute']]['combination'] = $attr;
            if (!isset($combinations[$attr['id_product_attribute']]['combination_name']))
            {
                $combinations[$attr['id_product_attribute']]['combination_name'] = '';
            }

            $combinations[$attr['id_product_attribute']]['combination_name'] = $combinations[$attr['id_product_attribute']]['combination_name'] . $attr['group_name'] . ": " . $attr['attribute_name'] . ", ";
            if (isset($combination_images[$attr['id_product_attribute']]['0']))
            {
                $combinations[$attr['id_product_attribute']]['image'] = $combination_images[$attr['id_product_attribute']]['0'];
            }
            else
            {
                $combinations[$attr['id_product_attribute']]['image'] = 0;
            }

            $gr = new AttributeGroupCore($attr['id_attribute_group']);
            $gr_atr = new Attribute($attr['id_attribute']);
            $combinations[$attr['id_product_attribute']]['attributes'][$gr->position]['name'] = $attr['attribute_name'];
            $combinations[$attr['id_product_attribute']]['attributes'][$gr->position]['type'] = $gr->group_type;
            $combinations[$attr['id_product_attribute']]['attributes'][$gr->position]['color'] = $gr_atr->color;
            ksort($combinations[$attr['id_product_attribute']]['attributes']);
        }
        return $combinations;
    }
}

class mqcUpdate extends mqc
{
    public static function version($version)
    {
        $version = (int)str_replace(".", "", $version);
        if (strlen($version) == 3) {
            $version = (int)$version . "0";
        }
        if (strlen($version) == 2) {
            $version = (int)$version . "00";
        }
        if (strlen($version) == 1) {
            $version = (int)$version . "000";
        }
        if (strlen($version) == 0) {
            $version = (int)$version . "0000";
        }

        return (int)$version;
    }

    public static function encrypt($string)
    {
        return base64_encode($string);
    }

    public static function verify($module, $key, $version)
    {
        if (ini_get("allow_url_fopen")) {
            if (function_exists("file_get_contents")) {
                $actual_version = @file_get_contents('http://dev.mypresta.eu/update/get.php?module=' . $module . "&version=" . self::encrypt($version) . "&lic=$key&u=" . self::encrypt(_PS_BASE_URL_ . __PS_BASE_URI__));
            }
        }
        Configuration::updateValue("update_" . $module, date("U"));
        Configuration::updateValue("updatev_" . $module, $actual_version);

        return $actual_version;
    }
}

?>