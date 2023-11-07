{if $restriction}
    <div class="mqc_message">
        {l s='You can order: ' mod='mqc'}{$restriction.quantity} {l s='quantity of this product' mod='mqc'}
    </div>
{/if}

{if isset($matrix_qty) && $matrix_qty != NULL}
    <div class="mqc_message">
        {l s='Some of product\'s variants have maximum allowed quantity conditions' mod='mqc'}
        <table class="mqc_table">
            {foreach $restriction_attributes item=pa key=cpa}
                {if isset($matrix_qty[$cpa])}
                    <tr>
                        <td>{$pa.combination_name|substr:0:-2}</td>
                        <td>{$matrix_qty[$cpa]}</td>
                    </tr>
                {/if}
            {/foreach}
        </table>
    </div>
{/if}

{if Configuration::get('MQC_CONTROL_QTY') == 1 && $restriction}
    <script>
        var product_page_mqc = {$restriction.quantity|intval};
        var product_page_mqc_attributes = {$matrix_qty|json_encode nofilter};

        {literal}
        document.addEventListener('DOMContentLoaded', function (event) {
            var timesRunMqc = 0;
            var checkExistsMqc = setInterval(function () {
                timesRunMqc += 1;
                if (timesRunMqc === 120) {
                    clearInterval(interval);
                }
                if ($('#quantity_wanted').length) {
                    $('#quantity_wanted').trigger("touchspin.updatesettings", {max: getMqc()});
                    $('#quantity_wanted').addClass('disabled');
                    clearInterval(checkExistsMqc);
                }
            }, 100);
        });
        {/literal}
    </script>
{/if}