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

<div class="card">
    <div class="card-header">{l s='Define maximum quantity of product in order' mod='mqc'}</div>
    <div style="padding:10px">
        <input type="hidden" name="saveMqchidden" value="1"/>
        <div class="bootstrap">
            <div class="alert alert-info">
                {l s='Define quantity of product. Customer will not be able to put more products to cart during order process.' mod='mqc'}
            </div>
            <div class="alert alert-info">
                {l s='Leave field empty if you do not want to create such restriction.' mod='mqc'}
            </div>
        </div>
        {if Tools::isSubmit("actionMqc")}
            {if Tools::getValue("actionMqc")=="saveMqc"}
                <div class="bootstrap">
                    <div class="alert alert-success">
                        {l s='Changes saved' mod='mqc'}
                    </div>
                </div>
            {/if}
        {/if}
        <input type="hidden" name="id_product" value="{Tools::getValue('id_product')|escape:'int'}"/>
        <div class="card">
            <div class="card-header">{l s='Quantities' mod='mqc'}</div>
            <table class="table">
                {foreach Group::getGroups(Configuration::get('PS_LANG_DEFAULT')) as $group}
                    <tr>
                        <td style="text-align:center; padding:10px; border:1px solid #f3f3f3;">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">{$group.name|escape:'html':'UTF-8'}</span></div>
                                <input class="form-control" name="selectedGroupsMqc[{$group.id_group|escape:'int':'utf-8'}]" value="{Mqc::getRestrictionsByGroupValue(Tools::getValue('id_product'),$group.id_group)|escape:'int':'utf-8'}"/>
                            </div>
                        </td>
                    </tr>
                {/foreach}
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">{l s='Define maximum quantity of product\'s combination in order' mod='mqc'}</div>
    <div style="padding:10px">
        <div class="bootstrap">
            <div class="alert alert-info">
                {l s='You can also specify values of maximum quantity for product combinations too.' mod='mqc'}
            </div>
        </div>
        <div class="card">
            <div class="card-header">{l s='Quantities' mod='mqc'}</div>
            <table class="table">
                <th>{l s='Combination' mod='mqc'}</th>
                {foreach Group::getGroups(Configuration::get('PS_LANG_DEFAULT')) as $group}
                    <th>{$group.name|escape:'html':'UTF-8'}</th>
                {/foreach}
                {foreach $product_attributes item=pa key=cpa}
                    <tr>
                        <td>{$pa.combination_name}</td>
                        {foreach Group::getGroups(Configuration::get('PS_LANG_DEFAULT')) as $group}
                            <td><input class="form-control" type="text" name="selectedCombinationMqc[{$cpa}][{$group.id_group|escape:'int':'utf-8'}]" value="{Mqc::getRestrictionsAttributesByGroupValue((int)Tools::getValue('id_product'),$cpa,$group.id_group)|escape:'int':'utf-8'}"/></td>
                        {/foreach}
                    </tr>
                {/foreach}
            </table>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">{l s='Maximum quantity for all purchases' mod='mqc'}</div>
    <div style="padding:10px">
        <div class="bootstrap">
            <div class="alert alert-info">
                {l s='All purchases' mod='mqc'} - {l s='Define maximum quantity of product that customer can order (products from previous orders included to calculation)' mod='mqc'}
            </div>
        </div>
        <div class="bootstrap" style="margin-top:20px;">
            <div class="alert alert-info">
                {l s='Leave field empty if you do not want to create such restriction.' mod='mqc'}
            </div>
        </div>
        <div class="card">
            <div class="card-header">{l s='Quantities' mod='mqc'}</div>
            <table class="table">
                {foreach Group::getGroups(Configuration::get('PS_LANG_DEFAULT')) as $group}
                    <tr>
                        <td style="text-align:center; padding:10px; border:1px solid #f3f3f3;">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">{$group.name|escape:'html':'UTF-8'}</span></div>
                                <input type="text" class="form-control" name="selectedGroupsMqcTotal[{$group.id_group|escape:'int':'utf-8'}]" value="{Mqc::getRestrictionsTotalByGroupValue(Tools::getValue('id_product'),$group.id_group)|escape:'int':'utf-8'}"/>
                            </div>
                        </td>
                    </tr>
                {/foreach}
            </table>
        </div>
    </div>
</div>
<input type="hidden" name="saveMqchidden" value="1"/>