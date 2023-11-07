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
<script type="application/javascript">
    $(function () {
        $(document).on("click", ".accordion-header", function() {
            $(this).toggleClass("active").next().slideToggle();
        });
    });
</script>
<p class="alert alert-info info">{l s='Selected module pages/controllers will be granted access to your shop.' mod='privateshop'}</p>
{if isset($module_pages) && $module_pages}
    {foreach item=pages from=$module_pages key=name}
            <div class="panel">
                <h3 class="accordion-header">{$name|escape:'htmlall':'UTF-8'}</h3>
                <div class="accordion-content">
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>{l s='Page ID' mod='privateshop'}</th>
                                <th>{l s='Page Name' mod='privateshop'}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach item=page from=$pages key=k}
                                <tr>
                                    <td width="10%">
                                        <label for="{$k|escape:'htmlall':'UTF-8'}">
                                            <input type="checkbox" name="MODULE_PAGES[]" value="{$k|escape:'htmlall':'UTF-8'}" {if isset($module_controllers) AND $module_controllers AND in_array($k, $module_controllers)}checked="checked"{/if}>
                                        </label>
                                    </td>
                                    <td width="60%">{$k|escape:'htmlall':'UTF-8'}</td>
                                    <td width="30%"><strong id="{$k|escape:'htmlall':'UTF-8'}">{$page|escape:'htmlall':'UTF-8'}</strong></td>
                                </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
    {/foreach}
{else}
    <p>{l s='There are no module pages' mod='privateshop'}</p>
{/if}
