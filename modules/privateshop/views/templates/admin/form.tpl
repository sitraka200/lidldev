{*
* PrivateShop
*
* Do not edit or add to this file.
* You are not authorized to modify, copy or redistribute this file.
* Permissions are reserved by FME Modules.
*
*  @author    FME Modules
*  @copyright 2017 FME Modules All right reserved
*  @license   FME Modules
*  @category  FMM Modules
*  @package   PrivateShop
*}
<script type="text/javascript" src="{$smarty.const.__PS_BASE_URI__|escape:'htmlall':'UTF-8'}js/jquery/plugins/jquery.colorpicker.js"></script>
<script type="text/javascript">
$(document).ready(function(){
   //$('#currentFormTab').val('general');
   displayPrivateTab('general');
})
function displayPrivateTab(tab)
{
    $('.private_tab').hide();
    $('.private_tab_page').removeClass('selected');
    $('#privateshop_' + tab).show();
    $('#privateshop_link_' + tab).addClass('selected');
    $('#currentFormTab').val(tab);
}
</script>
<div class="well private_shop_container">
    <div class="toolbarBox pageTitle">
        <h3 class="tab panel-heading">&nbsp;<img src="{$smarty.const.__PS_BASE_URI__|escape:'htmlall':'UTF-8'}modules/privateshop/views/img/shop.png"/> {l s='Private Shop' mod='privateshop'}</h3>
    </div>
    <div class="col-lg-2 " id="private-shop">
     	<div class="productTabs">
    		<ul class="tab">
    			<li class="tab-row">
    				<a class="private_tab_page selected" id="privateshop_link_general" href="javascript:displayPrivateTab('general');">{l s='General Settings' mod='privateshop'}</a>
    			</li>
    			<li class="tab-row">
    				<a class="private_tab_page" id="privateshop_link_control" href="javascript:displayPrivateTab('control');">{l s='Access Control' mod='privateshop'}</a>
    			</li>
    			<li class="tab-row">
    				<a class="private_tab_page" id="privateshop_link_customers" href="javascript:displayPrivateTab('customers');">{l s='Private Customers' mod='privateshop'}</a>
    			</li>
       <li class="tab-row">
    				<a class="private_tab_page" id="privateshop_link_groups" href="javascript:displayPrivateTab('groups');">{l s='Group Access' mod='privateshop'}</a>
    			</li>
       <li class="tab-row">
           <a class="private_tab_page" id="privateshop_link_modulepages" href="javascript:displayPrivateTab('modulepages');">{l s='Module Pages' mod='privateshop'}</a>
       </li>
       <li class="tab-row">
           <a class="private_tab_page" id="privateshop_link_restricturls" href="javascript:displayPrivateTab('restricturls');">{l s='Restrict URLs' mod='privateshop'}</a>
       </li>
       <li class="tab-row">
           <a class="private_tab_page" id="privateshop_link_urlsallowed" href="javascript:displayPrivateTab('urlsallowed');">{l s='Allowed URLs' mod='privateshop'}</a>
       </li>
                 {if $multishop == 1 AND isset($shops) AND $shops}
                    <li class="tab-row">
                    <a class="private_tab_page" id="privateshop_link_shops" href="javascript:displayPrivateTab('shops');">{l s='Shops' mod='privateshop'}</a>
                </li>
                {/if}
    		</ul>
    	</div>
    </div>
    <!-- Tab Content -->
    <form action="{$URL|escape:'htmlall':'UTF-8'}" name="privateshop_form" id="privateshop_form" method="post" enctype="multipart/form-data" class="col-lg-10 panel form-horizontal" {if $version < 1.6}style="margin-left: 145px;"{/if}>
        <input type="hidden" id="currentFormTab" name="currentFormTab" value="general" />
        <div id="privateshop_general" class="private_tab tab-pane">
            <h3 class="tab"><img src="{$smarty.const.__PS_BASE_URI__|escape:'htmlall':'UTF-8'}modules/privateshop/views/img/config.png"/> {l s='General Settings' mod='privateshop'}</h3><div class="separation"></div>
            {include file="../admin/general_settings.tpl"}
        </div>
        <div id="privateshop_control" class="private_tab tab-pane" style="display:none;">
            <h3 class="tab"><img src="{$smarty.const.__PS_BASE_URI__|escape:'htmlall':'UTF-8'}modules/privateshop/views/img/access.png"/> {l s='Access Control' mod='privateshop'}</h3><div class="separation"></div>
            {include file="../admin/access_control.tpl"}
        </div>
        <div id="privateshop_customers" class="private_tab tab-pane" style="display:none;">
            <h3 class="tab"><img src="{$smarty.const.__PS_BASE_URI__|escape:'htmlall':'UTF-8'}modules/privateshop/views/img/usr.png"/> {l s='Private Customers' mod='privateshop'}</h3><div class="separation"></div>
           {include file="../admin/customers.tpl"}
        </div>
        <div class="separation"></div>
        <div id="privateshop_groups" class="private_tab tab-pane" style="display:none;">
            <h3 class="tab"><img src="{$smarty.const.__PS_BASE_URI__|escape:'htmlall':'UTF-8'}modules/privateshop/views/img/group.png"/> {l s='Customer Group Access' mod='privateshop'}</h3><div class="separation"></div>
           {include file="../admin/groups.tpl"}
        </div>
        <div class="separation"></div>
        <div id="privateshop_modulepages" class="private_tab tab-pane" style="display:none;">
            <h3 class="tab"><i class="icon-file"></i> {l s='Module Related Pages/Controllers' mod='privateshop'}</h3>
            <div class="separation"></div>
            {include file="../admin/pages.tpl"}
        </div>
        <div class="separation"></div>
        <div id="privateshop_restricturls" class="private_tab tab-pane" style="display:none;">
            <h3 class="tab"><i class="icon-eye-slash"></i> {l s='Restrict URLs' mod='privateshop'}</h3>
            <div class="separation"></div>
            {include file="../admin/restrict-urls.tpl"}
        </div>
        <div class="separation"></div>
        <div id="privateshop_urlsallowed" class="private_tab tab-pane" style="display:none;">
            <h3 class="tab"><i class="icon-eye"></i> {l s='Allowed URLs' mod='privateshop'}</h3>
            <div class="separation"></div>
            {include file="../admin/urls.tpl"}
        </div>
        <div class="separation"></div>

        {if $multishop == 1 AND isset($shops) AND $shops}
            <div id="privateshop_shops" class="private_tab tab-pane" style="display:none;">
                <h3 class="tab"><img src="{$smarty.const.__PS_BASE_URI__|escape:'htmlall':'UTF-8'}modules/privateshop/views/img/shop.png"/> {l s='Shop Association' mod='privateshop'}</h3>
                {include file="../admin/shops.tpl"}
            </div><div class="clearfix"></div>
        {/if}
        
        {if $version >= 1.6}
            <div class="panel-footer">
                <button class="btn btn-default pull-right" name="saveConfiguration" type="submit">
                    <i class="process-icon-save"></i>
                    {l s='Save' mod='privateshop'}
                </button>
            </div>
        {else}
            <div style="text-align:center">
                <input type="submit" value="{l s='Save' mod='privateshop'}" class="button" name="saveConfiguration"/>
            </div>
        {/if}
    </form>
   <div class="clearfix"></div>
</div>
<br></br>
<div class="clearfix"></div>
{literal}
<style type="text/css">
/*== PS 1.6 ==*/
 #private-shop ul.tab { list-style:none; padding:0; margin:0}

 #private-shop ul.tab li a {background-color: white;border: 1px solid #DDDDDD;display: block;margin-bottom: -1px;padding: 10px 15px;}
 #private-shop ul.tab li a { display:block; color:#555555; text-decoration:none}
 #private-shop ul.tab li a.selected { color:#fff; background:#00AFF0}

 #privateshop_toolbar { clear:both; padding-top:20px; overflow:hidden}

 #privateshop_toolbar .pageTitle { min-height:90px}

 #privateshop_toolbar ul { list-style:none; float:right}

 #privateshop_toolbar ul li { display:inline-block; margin-right:10px}

 #privateshop_toolbar ul li .toolbar_btn {background-color: white;border: 1px solid #CCCCCC;color: #555555;-moz-user-select: none;background-image: none;border-radius: 3px 3px 3px 3px;cursor: pointer;display: inline-block;font-size: 12px;font-weight: normal;line-height: 1.42857;margin-bottom: 0;padding: 8px 8px;text-align: center;vertical-align: middle;white-space: nowrap; }

 #privateshop_toolbar ul li .toolbar_btn:hover { background-color:#00AFF0 !important; color:#fff;}

 #privateshop_form .language_flags { display:none}
 form#privateshop_form {
    background-color: #ebedf4;
    border: 1px solid #ccced7;
    /*min-height: 404px;*/
    padding: 5px 10px 10px;
}
</style>
{/literal}
