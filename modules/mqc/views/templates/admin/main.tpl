{**
* PrestaShop module created by VEKIA, a guy from official PrestaShop community ;-)
*
* @author    VEKIA https://www.prestashop.com/forums/user/132608-vekia/
* @copyright 2010-2019 VEKIA
* @license   This program is not free software and you can't resell and redistribute it
*
* CONTACT WITH DEVELOPER
* support@mypresta.eu
*}

<div id="mqc" class="clearfix">
    <div class="col-md-3 productTabs">
        <div class="panel">
            <h3>
                <i class="icon-cogs"></i> {l s='Main settings' mod='mqc'}
            </h3>
            <h4>{l s='Options' mod='mqc'}</h4>
            <ul class="tab">
                <li class="mqc_global_main_settings tab-row"><a href="javascript:displayCartRuleTab('mqc_global_main_settings');" >{l s='Global settings' mod='mqc'}</a></li>
            </ul>
        </div>

        <div class="panel">
            <h3>
                <i class="icon-cogs"></i> {l s='Maximum quantity of product in cart' mod='mqc'}
            </h3>
            <div class="alert alert-info">
                {l s='Set the limit of maximum purchases for products. These settings are applicable for carts' mod='mqc'}
            </div>
            <h4>{l s='Options' mod='mqc'}</h4>
            <ul class="tab">
                <li class="mqc_global_form tab-row"><a href="javascript:displayCartRuleTab('mqc_global_form');" >{l s='Global product\'s max cart quantity' mod='mqc'}</a></li>
                <li class="mqc_mass_mqc tab-row"><a href="javascript:displayCartRuleTab('mqc_mass_mqc');">{l s='Mass generate quantity limits' mod='mqc'}</a></li>
            </ul>
        </div>
        <div class="panel">
            <h3>
                <i class="icon-cogs"></i> {l s='Maximum quantity for all purchases' mod='mqc'}
            </h3>
            <div class="alert alert-info">
                {l s='Set global quantity limits for products - settings here are applicable for all purchases in the shop (not for one cart as previous one)' mod='mqc'}
            </div>
            <h4>{l s='Options' mod='mqc'}</h4>
            <ul class="tab">
                <li class="mqc_orders_mqc tab-row"><a href="javascript:displayCartRuleTab('mqc_orders_mqc');" >{l s='Main settings of feature' mod='mqc'}</a></li>
                <li class="mqc_orders_mqc_orders tab-row"><a href="javascript:displayCartRuleTab('mqc_orders_mqc_orders');">{l s='Mass generate quantity limits' mod='mqc'}</a></li>

            </ul>
        </div>
    </div>
    <div class="col-md-9">
        <div id="mqc_global_main_settings" class="mqc_form" style="display:none;">
            {$mqc_global_main_settings nofilter}
        </div>
        <div id="mqc_global_form" class="mqc_form" style="display:none;">
            {$mqc_global_form nofilter}
        </div>
        <div id="mqc_mass_mqc" class="mqc_form" style="display:none;">
            {$mqc_mass_mqc nofilter}
        </div>
        <div id="mqc_orders_mqc" class="mqc_form" style="display:none;">
            {$mqc_orders_mqc nofilter}
        </div>
        <div id="mqc_orders_mqc_orders" class="mqc_form" style="display:none;">
            {$mqc_orders_mqc_orders nofilter}
        </div>
    </div>
</div>

<style type="text/css">
    /*== PS 1.6 ==*/
    #mqc ul.tab {
        list-style: none;
        padding: 0;
        margin: 0
    }

    #mqc ul.tab a {
        cursor:pointer;
    }

    #mqc ul.tab li a {
        background-color: white;
        border: 1px solid #DDDDDD;
        display: block;
        margin-bottom: -1px;
        padding: 10px 15px;
    }

    #mqc ul.tab li a {
        display: block;
        color: #555555;
        text-decoration: none
    }

    #mqc ul.tab li a.selected {
        color: #fff;
        background: #00AFF0;
        border: 1px solid #00AFF0;
    }
</style>

<script>
    {if Tools::isSubmit('btnSubmit')}
        $(document).ready(function () {
            displayCartRuleTab('mqc_global_form');
        });
    {elseif Tools::isSubmit('submit_MQC_MASS')}
        $(document).ready(function () {
            displayCartRuleTab('mqc_mass_mqc');
        });
    {elseif Tools::isSubmit('btnSubmit_ostates')}
        $(document).ready(function () {
            displayCartRuleTab('mqc_orders_mqc');
        });
    {elseif Tools::isSubmit('submit_MQC_MASS_ORDERS')}
        $(document).ready(function () {
            displayCartRuleTab('mqc_orders_mqc_orders');
        });
    {else}
        $(document).ready(function () {
            displayCartRuleTab('mqc_global_form');
        });
    {/if}
    function displayCartRuleTab(tab) {
        $('.mqc_form').hide();
        $('.tab-row a').removeClass('selected');
        $('.'+tab+' a').addClass('selected');
        $('#'+tab).show();
    }
</script>