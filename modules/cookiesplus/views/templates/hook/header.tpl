{*
 * Cookies Plus
 *
 * NOTICE OF LICENSE
 *
 * This product is licensed for one customer to use on one installation (test stores and multishop included).
 * Site developer has the right to modify this module to suit their needs, but can not redistribute the module in
 * whole or in part. Any other use of this module constitues a violation of the user agreement.
 *
 * DISCLAIMER
 *
 * NO WARRANTIES OF DATA SAFETY OR MODULE SECURITY
 * ARE EXPRESSED OR IMPLIED. USE THIS MODULE IN ACCORDANCE
 * WITH YOUR MERCHANT AGREEMENT, KNOWING THAT VIOLATIONS OF
 * PCI COMPLIANCY OR A DATA BREACH CAN COST THOUSANDS OF DOLLARS
 * IN FINES AND DAMAGE A STORES REPUTATION. USE AT YOUR OWN RISK.
 *
 *  @author    idnovate.com <info@idnovate.com>
 *  @copyright 2017 idnovate.com
 *  @license   See above
*}

<style>
    #cookie-bar { background:{$CK_notice_bg_color|escape:'htmlall':'UTF-8'}; height:auto; line-height:24px; color:{$CK_notice_text_color|escape:'htmlall':'UTF-8'}; text-align:center; padding:10px 0; opacity:{$CK_notice_bg_opacity|escape:'htmlall':'UTF-8'}; z-index: 99999; }
    #cookie-bar a { color:{$CK_notice_text_color|escape:'htmlall':'UTF-8'}; }
    #cookie-bar.fixed { position:fixed; top:0; left:0; width:100%; }
    #cookie-bar.fixed.bottom { bottom:0; top:auto; }
    #cookie-bar p { margin:0; padding:0; }
    #cookie-bar a.cb-button { color: {$CK_notice_text_color|escape:'htmlall':'UTF-8'}; display:inline-block; border-radius:3px; text-decoration:none; padding:0 6px; margin-left:8px; }
    #cookie-bar a.cb-enable { color: {$CK_accept_button_text_color|escape:'htmlall':'UTF-8'}; background: {$CK_accept_button_bg_color|escape:'htmlall':'UTF-8'}; }
    #cookie-bar a.cb-enable:hover { background: {$CK_accept_button_bg_hover_color|escape:'htmlall':'UTF-8'}; }
    #cookie-bar a.cb-disable { color: {$CK_decline_button_text_color|escape:'htmlall':'UTF-8'}; background: {$CK_decline_button_bg_color|escape:'htmlall':'UTF-8'}; }
    #cookie-bar a.cb-disable:hover { background: {$CK_decline_button_bg_hover_color|escape:'htmlall':'UTF-8'}; }
    #cookie-bar a.cb-policy { color: {$CK_policy_button_text_color|escape:'htmlall':'UTF-8'}; background: {$CK_policy_button_bg_color|escape:'htmlall':'UTF-8'}; }
    #cookie-bar a.cb-policy:hover { background: {$CK_policy_button_bg_hover_color|escape:'htmlall':'UTF-8'}; }
</style>

<script>
    // <![CDATA[
    var CK_mode = "{$CK_mode|escape:'htmlall':'UTF-8'}";
    var CK_name = "{$CK_name|escape:'htmlall':'UTF-8'}";
    var CK_exception = "{$CK_exception|escape:'htmlall':'UTF-8'}";
    var CK_accept_move = {$CK_accept_move|escape:'htmlall':'UTF-8'};
    var CK_accept_scroll = {$CK_accept_scroll|escape:'htmlall':'UTF-8'};
    var CK_accept_click = {$CK_accept_click|escape:'htmlall':'UTF-8'};
    var CK_accept_timeout = {$CK_accept_timeout|escape:'htmlall':'UTF-8'};
    var CK_accept_timeout_s = {$CK_accept_timeout_s|escape:'htmlall':'UTF-8'};
    var CK_message = "{$CK_message|regex_replace:'/[\r\t\n][\r\t\n]/':'<br />'|regex_replace:'/[\r\t\n]/':'<br />'|regex_replace:"/[\r\n]/" : " "|regex_replace:'/[\']/':'\''|replace:'"':'\'' nofilter}";
    var CK_accept_button = {$CK_accept_button|escape:'htmlall':'UTF-8'};
    var CK_accept_button_text = "{$CK_accept_button_text|escape:'htmlall':'UTF-8'}";
    var CK_decline_button = {$CK_decline_button|escape:'htmlall':'UTF-8'};
    var CK_decline_button_text = "{$CK_decline_button_text|escape:'htmlall':'UTF-8'}";
    var CK_policy_button = {$CK_policy_button|escape:'htmlall':'UTF-8'};
    var CK_policy_button_text = "{$CK_policy_button_text|escape:'htmlall':'UTF-8'}";
    var CK_cms_page = "{$CK_cms_page|escape:'htmlall':'UTF-8'}";
    var CK_cookie_expiry = {$CK_cookie_expiry|escape:'htmlall':'UTF-8'};
    var CK_decline_button_url = "{$CK_decline_button_url|escape:'htmlall':'UTF-8'}";
    var CK_notice_position = {$CK_notice_position|escape:'htmlall':'UTF-8'};
    var CK_notice_fixed = {$CK_notice_fixed|escape:'htmlall':'UTF-8'};
    var CK_notice_effect = "{$CK_notice_effect|escape:'htmlall':'UTF-8'}";
    var CK_notice_fixed_bottom = {$CK_notice_fixed_bottom|escape:'htmlall':'UTF-8'};
    // ]]>
</script>
