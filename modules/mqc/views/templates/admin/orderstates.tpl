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

<div class="panel col-lg-12">
    <h3><i class="icon-wrench"></i> {l s='Order states' mod='mqc'}</h3>
    <div class="alert alert-info">
        {l s='Select order states. Module will count products from orders with at least one order state selected below' mod='mqc'}
    </div>

    <div class="table-responsive-row clearfix">
        <table class="table configuration">
            <thead>
            <tr class="nodrag nodrop">
                <th class="fixed-width-xs text-center">
                    <span class="title_box">{l s='ID' mod='mqc'}</span>
                </th>
                <th class="">
                    <span class="title_box">{l s='Name' mod='mqc'}</span>
                </th>
                <th class="">
                    <span class="title_box">{l s='Select' mod='mqc'}</span>
                </th>
            </tr>
            </thead>
            <tbody>
            {foreach $orderStates AS $ostate}
                <tr class="pointer {if $ostate@iteration is odd by 1}odd{/if}">
                    <td class="fixed-width-xs text-center">
                        {$ostate.id_order_state}
                    </td>
                    <td class="fixed-width-xs text-left">
                        <span class="label color_field" style="background-color:{$ostate.color}; color:{if Tools::getBrightness($ostate.color) < 128}white{else}#383838{/if}">
                            {$ostate.name}
                        </span>
                    </td>
                    <td>
                        <input type="checkbox" name="MQC_ORDERSTATES[]" value="{$ostate.id_order_state}" {if in_array($ostate.id_order_state, $MQC_ORDERSTATES)}checked="checked"{/if}>
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
</div>