{**
* PrestaShop module created by VEKIA, a guy from official PrestaShop community ;-)
*
* @author    VEKIA https://www.prestashop.com/forums/user/132608-vekia/
* @copyright 2010-2019  VEKIA
* @license   This program is not free software and you can't resell and redistribute it
*
* CONTACT WITH DEVELOPER
* support@mypresta.eu
*}

<div class="mqcalertcart">
    <div class="alert alert-danger">
        {l s='You reached the purchases limit for products listed below' mod='mqc'}<br/>
        <ul>
            {foreach $reached_limits AS $pr}
                <li>
                    {l s='The limit for product' mod='mqc'} <strong>{$pr['name']}</strong> {l s='is:' mod='mqc'} <strong>{$pr['limit']}</strong>. {l s='You previously bought: ' mod='mqc'} <strong>{$pr['total_qty']}</strong>. {l s='Current quantity in cart is ' mod='mqc'} <strong>{$pr['cart']}</strong>
                </li>
            {/foreach}
        </ul>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        $.fancybox({
            content: '<div class="mqcalertcart">' + $('.mqcalertcart').html() + '</div>',
            type: 'html',
        });
    });
</script>