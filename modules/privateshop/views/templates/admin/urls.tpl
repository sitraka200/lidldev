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
<p class="alert alert-info info">{l s='Entered URLs will be granted access to your shop.' mod='privateshop'}</p>
<div class="panel" id="fmm_ps_field_wrapper">
    <div class="col-lg-10" id="fmm_ps_field_holder">
            {if isset($whitelist_urls) && !empty($whitelist_urls)}
            {foreach item=whiteurl from=$whitelist_urls}
                        <div><input type="text" name="whiteurls[]" value="{$whiteurl.url|escape:'htmlall':'UTF-8'}" /><i class="icon-trash" onclick="dumpThisField(this);"></i></div>
            {/foreach}
            {else}
                        <div><input type="text" name="whiteurls[]" placeholder="https://addons.prestashop.com/en/139_fme-modules" /><i class="icon-trash" onclick="dumpThisField(this);"></i></div>
            {/if}
    </div>
    <div class="col-lg-2 pull-right">
            <button type="button" class="btn btn-default pull-right" onclick="addFieldUrls();"><i class="icon-plus"></i> {l s='Add More' mod='privateshop'}</button>
    </div>
</div>


<style type="text/css">{literal}
#fmm_ps_field_wrapper:after { content: "."; clear: both; display: block; visibility: hidden; height: 0px;}
#fmm_ps_field_holder input { margin: 10px 0; display: inline-block; width: 92%; margin-right: 1%;}
#fmm_ps_field_holder i { display: inline-block; cursor: pointer;}
#fmm_ps_field_wrapper .pull-right { margin: 5px 0;}
</style>
<script type="text/javascript">
function addFieldUrls() {
            $('#fmm_ps_field_holder').append('<div><input type="text" name="whiteurls[]" placeholder="https://addons.prestashop.com/en/139_fme-modules"/><i class="icon-trash" onclick="dumpThisField(this);"></i></div>');
}
function dumpThisField(el) {
            $(el).parent().remove();
}
</script>
{/literal}