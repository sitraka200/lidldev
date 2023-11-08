{**
 * 2007-2017 PrestaShop
*
* NOTICE OF LICENSE
*
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="links block_newsletter block col-lg-12 col-md-12 col-sm-12">


  <h3 class="block_title hidden-md-down">{l s='Subscribe Now' d='Shop.Theme.Global'}</h3>

  <h3 class="block_title hidden-lg-up title" data-target="#block_email_toggle" data-toggle="collapse">{l s='Subscribe Now' d='Shop.Theme.Global'}
    <span class="pull-xs-right">
      <span class="navbar-toggler collapse-icons">
        <i class="material-icons add">&#xE313;</i>
        <i class="material-icons remove">&#xE316;</i>
      </span>
    </span>
  </h3>
  <div class="col-md-12 col-xs-12 block_content collapse" id="block_email_toggle">
    {if $conditions}
    <p class="text">{$conditions}</p>
    {/if}
    <form action="{$urls.pages.index}#footer" method="post">

      <div class="col-xs-12">

        <div class="input-wrapper">
          {* NEW CHANGE: ADD THIS FIELD FOR MODULE PS EMAIL SUBSCRIPTION VERSION 2.5.0 OR UPPER *}
          <input 
          type="hidden" 
          name="blockHookName" 
          value="{$hookName}">
          {* END NEW CHANGE *}

          <input
          name="email"
          type="email"
          value="{$value}"
          placeholder="{l s='Enter Your ID' d='Shop.Theme.Global'}"
          aria-labelledby="block-newsletter-label"
          >

          <input
          class="btn btn-primary pull-xs-right hidden-xs-down"
          name="submitNewsletter"
          type="submit"
          value="{l s='Subscribe' d='Shop.Theme.Actions'}"
          >

          <input
          class="btn btn-primary pull-xs-right hidden-sm-up"
          name="submitNewsletter"
          type="submit"
          value="{l s='OK' d='Shop.Theme.Actions'}"
          >

          <input type="hidden" name="action" value="0">
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="col-xs-12">
        {if $msg}
        <p class="alert {if $nw_error}alert-danger{else}alert-success{/if}">
          {$msg}
        </p>
        {/if}
      </div>

    </form>
  </div>
</div>