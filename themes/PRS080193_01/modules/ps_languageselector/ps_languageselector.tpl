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

<!-- <div id="_desktop_language_selector">
  <div class="language-selector-wrapper">
    <!--<span class="hidden-md-up">{l s='Language:' d='Shop.Theme.Global'}</span>
    <div class="language-selector dropdown js-dropdown">
      <span class="expand-more hidden-md-down" data-toggle="dropdown">{l s='language' d='Shop.Theme.Global'}</span>
      <a data-target="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="hidden-md-down">
        <i class="material-icons expand-more">&#xE5CF;</i>
      </a>
      <ul class="dropdown-menu hidden-md-down" aria-labelledby="language-selector-label">
        {foreach from=$languages item=language}
          <li {if $language.id_lang == $current_language.id_lang} class="current" {/if}>
            <a href="{url entity='language' id=$language.id_lang}" class="dropdown-item"><img src="img/l/{$language.id_lang}.jpg" alt="{$language.iso_code}" width="16" height="11" />{$language.name_simple}</a>
          </li>
        {/foreach}
      </ul>
      <select class="link hidden-lg-up" aria-labelledby="language-selector-label">
        {foreach from=$languages item=language}
          <option value="{url entity='language' id=$language.id_lang}"{if $language.id_lang == $current_language.id_lang} selected="selected"{/if}>{$language.name_simple}</option>
        {/foreach}
      </select>
    </div>
  </div>
</div> -->
<div id="_desktop_language_selector">
    <div class="language-selector-wrapper">
        <div class="current">
            <span class="cur-label">{l s='Language'  d='Shop.Theme.Global'} :</span>

        </div>
        <div class="language-selector dropdown js-dropdown">

            <span class="expand-more hidden-md-down" data-toggle="dropdown">

      <ul class="dropdown-menu hidden-md-down languages-block_ul" aria-labelledby="language-selector-label">
        {foreach from=$languages item=language}
          <li {if $language.id_lang == $current_language.id_lang} class="current" {/if}>
            <a href="{url entity='language' id=$language.id_lang}" class="dropdown-item"><img src="img/l/{$language.id_lang}.jpg" alt="{$language.iso_code}" width="16" height="11" /></a>
          </li>
        {/foreach}
      </ul>
      <select class="link hidden-lg-up" aria-labelledby="language-selector-label">
        {foreach from=$languages item=language}
          <option value="{url entity='language' id=$language.id_lang}" {if $language.id_lang == $current_language.id_lang} selected="selected"{/if}><img src="img/l/{$language.id_lang}.jpg" alt="{$language.name_simple}" width="30" height="20" /></option>
        {/foreach}
      </select>
      </span>
    </div>
  </div>
</div>