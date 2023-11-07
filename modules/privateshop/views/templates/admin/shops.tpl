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
<script type="text/javascript">
    var selected_shops = "{$selected_shops|escape:'htmlall':'UTF-8'}";
    $(document).ready(function()
    {
        // $('.displayed_flag').addClass('col-lg-3');
        $('.language_flags').css('float','left').hide();
        $(".pointer").addClass("btn btn-default dropdown-toggle");

        // shop association
        $(".tree-item-name input[type=checkbox]").each(function()
        {
            $(this).prop("checked", false);
            $(this).removeClass("tree-selected");
            $(this).parent().removeClass("tree-selected");
            if ($.inArray($(this).val(), selected_shops) != -1)
            {
                $(this).prop("checked", true);
                $(this).parent().addClass("tree-selected");
                $(this).parents("ul.tree").each(
                    function()
                    {
                        $(this).children().children().children(".icon-folder-close")
                            .removeClass("icon-folder-close")
                            .addClass("icon-folder-open");
                        $(this).show();
                    }
                );
            }
        });
    });
</script>
<!-- Shop settings-->
<div id="smpt-config-box" class="smpt-config-box">
    <div class="col-lg-12 margin-form form-group">
        {$shops}{* HTML content *}
    </div>
    <div class="clearfix"></div>
</div>