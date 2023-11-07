{*
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
*}
<p class="alert alert-info info">{l s='Checked customer groups below will be granted access to your shop.' mod='privateshop'}</p>
<div class="panel">
    <!-- customer group management -->
    <div class="col-lg-12 form-group margin-form">
    <label class="form-group control-label col-lg-3">{l s='Enable Group Management?' mod='privateshop'}</label>
    <div class="form-group margin-form ">
        <div class="col-lg-9">
            <span class="switch prestashop-switch fixed-width-lg">
                <input type="radio" name="PRIVATE_CUSTOMER_GROUP_STATE" id="PRIVATE_CUSTOMER_GROUP_STATE_on" value="1" {if isset($field_values) AND isset($field_values.cgroup_active) AND $field_values.cgroup_active == 1}checked="checked"{/if}/>
            <label class="t" for="PRIVATE_CUSTOMER_GROUP_STATE_on">{if $version < 1.6}<img src="../img/admin/enabled.gif" alt="Enabled" title="Enabled" />{else}{l s='Yes' mod='privateshop'}{/if}</label>
                <input type="radio" name="PRIVATE_CUSTOMER_GROUP_STATE" id="PRIVATE_CUSTOMER_GROUP_STATE_off" value="0" {if isset($field_values) AND isset($field_values.cgroup_active) AND $field_values.cgroup_active == 0}checked="checked"{/if}/>
            <label class="t" for="PRIVATE_CUSTOMER_GROUP_STATE_off">{if $version < 1.6}<img src="../img/admin/disabled.gif" alt="Disabled" title="Disabled" />{else}{l s='No' mod='privateshop'}{/if}</label>
                <a class="slide-button btn"></a>
            </span>
            <div class="help-block"><strong class="red_flag">*</strong>{l s='Note: Enabling this option will check for logged-in users group access permissions selected below.' mod='privateshop'}</div>
        </div>
    </div>
    </div>
    
    <div class="form-group margin-form">
        <label class="control-label col-lg-3">{l s='Select Groups' mod='privateshop'}</label>
        <div class="col-lg-9">
            <table class="table std table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th>{l s='ID' mod='privateshop'}</th>
                        <th>{l s='Group Name' mod='privateshop'}</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$groups item=group key=k}
                        <tr>
                            <td>
                                <input type="checkbox" id="g{$group.id_group|escape:'htmlall':'UTF-8'}" name="groups[]" value="{$group.id_group|escape:'htmlall':'UTF-8'}" {if isset($selected_groups) AND in_array($group.id_group, $selected_groups)}checked="checked"{/if}>
                            </td>
                            <td>{$group.id_group|escape:'htmlall':'UTF-8'}</td>
                            <td><label for="g{$group.id_group|escape:'htmlall':'UTF-8'}">{$group.name|escape:'htmlall':'UTF-8'}</label></td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
    </div>
    <div class="form-group margin-form">
        <label class="control-label col-lg-3">{l s='Restriction Message:' mod='privateshop'}</label>
        <div class="col-lg-6">
            {foreach from=$languages item=lang}
			<div class="lang_{$lang.id_lang}" id="cpara44_{$lang.id_lang}"{if $lang.id_lang != $active_lang} style="display:none;"{/if}>
				<textarea class="form-control" name="PRIVATE_CUSTOMER_GROUP_MSG_{$lang.id_lang}">{if isset($field_values) AND isset($field_values.cg_mesg[$lang.id_lang])}{$field_values.cg_mesg[$lang.id_lang]|escape:'htmlall':'UTF-8'}{/if}</textarea>
			</div>
			{/foreach}
            <div class="help-block"><strong class="red_flag">*</strong>{l s='Message for non-permitted users.' mod='privateshop'}</div>
        </div>
        <div class="col-lg-3">{$module->displayFlags($languages, Context::getContext()->language->id, 'cpara44&curren;dd', 'cpara44', true) nofilter}{*HTML Content*}</div>
    </div>
</div>