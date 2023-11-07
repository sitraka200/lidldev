{*
* PrivateShop
*
* Do not edit or add to this file.
* You are not authorized to modify, copy or redistribute this file.
* Permissions are reserved by FME Modules.
*
*  @author    FME Modules
*  @copyright 2019 FME Modules All right reserved
*  @license   FME Modules
*  @category  FMM Modules
*  @package   PrivateShop
*}
<p class="alert alert-info info">{l s='Entered URLs will be restricted.' mod='privateshop'}</p>
<div class="panel" id="fmm_ps_field_wrapper_rsu">
    <div class="col-lg-10" id="fmm_ps_field_holder_rsu">
            {if isset($restrict_urls) && !empty($restrict_urls)}
            {foreach item=rsurl from=$restrict_urls}
                <div><input type="text" name="restricturls[]" value="{$rsurl.url|escape:'htmlall':'UTF-8'}" /><i class="icon-trash" onclick="dumpThisField(this);"></i></div>
            {/foreach}
            {else}
                <div><input type="text" name="restricturls[]" placeholder="https://addons.prestashop.com/en/139_fme-modules" /><i class="icon-trash" onclick="dumpThisField(this);"></i></div>
            {/if}
    </div>
    <div class="col-lg-2 pull-right">
        <button type="button" class="btn btn-default pull-right" onclick="addFieldUrlsRsu();"><i class="icon-plus"></i> {l s='Add More' mod='privateshop'}</button>
    </div>
</div>


<style type="text/css">{literal}
#fmm_ps_field_wrapper_rsu:after { content: "."; clear: both; display: block; visibility: hidden; height: 0px;}
#fmm_ps_field_holder_rsu input { margin: 10px 0; display: inline-block; width: 92%; margin-right: 1%;}
#fmm_ps_field_holder_rsu i { display: inline-block; cursor: pointer;}
#fmm_ps_field_wrapper_rsu .pull-right { margin: 5px 0;}
</style>
<script type="text/javascript">
function addFieldUrlsRsu() {
    $('#fmm_ps_field_holder_rsu').append('<div><input type="text" name="restricturls[]" placeholder="https://addons.prestashop.com/en/139_fme-modules"/><i class="icon-trash" onclick="dumpThisField(this);"></i></div>');
}
</script>
{/literal}