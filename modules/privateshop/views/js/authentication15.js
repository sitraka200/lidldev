/*
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
*/
$(document).ready(function(){
        $('#create-account_form').submit(function(){
            submitFunction();
            return false;
        });
        $('#SubmitCreate').click(function(){
            submitFunction();
        });
    });
    function submitFunction()
    {
        $('#create_account_error').html('').hide();
        //send the ajax request to the server
        $.ajax({
            type: 'POST',
            url: baseUri,
            async: true,
            cache: false,
            dataType : "json",
            data: {
                controller: 'authentication',
                SubmitCreate: 1,
                ajax: true,
                email_create: $('#email_create').val(),
                token: token
            },
            success: function(jsonData)
            {
                if (jsonData.hasError)
                {
                    var errors = '';
                    for(error in jsonData.errors)
                        //IE6 bug fix
                        if(error != 'indexOf')
                            errors += '<li>'+jsonData.errors[error]+'</li>';
                    $('#create_account_error').html('<ol>'+errors+'</ol>').show();
                }
                else
                {
                    $('#wrapper').addClass('private_wrapper');
                    $('#wrapper').removeClass('center_align');
                    // adding a div to display a transition
                    $('#center_column').html('<div id="noSlide">'+$('#center_column').html()+'</div>');
                    $('#noSlide').fadeOut('slow', function(){
                        $('#noSlide').html(jsonData.page);
                        // update the state (when this file is called from AJAX you still need to update the state)
                        bindStateInputAndUpdate();
                    });
                    $('#noSlide').fadeIn('slow');
                    document.location = '#account-creation';
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                alert("TECHNICAL ERROR: unable to load form.\n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
            }
        });
    }
    function bindStateInputAndUpdate()
{
	$('select#id_country').change(function(){
		updateState();
		updateNeedIDNumber();
		updateZipCode();
	});
	
	if ($('select#id_country_invoice').length != 0)
	{
		$('select#id_country_invoice').change(function(){
			updateState('invoice');
			updateNeedIDNumber('invoice');
			updateZipCode();
		});
		if ($('select#id_country_invoice:visible').length != 0)
		{
			updateState('invoice');
			updateNeedIDNumber('invoice');
			updateZipCode('invoice');
		}
	}
	
	updateState();
	updateNeedIDNumber();
	updateZipCode();
}

function updateState(suffix)
{
	$('select#id_state'+(suffix !== undefined ? '_'+suffix : '')+' option:not(:first-child)').remove();
	var states = countries[$('select#id_country'+(suffix !== undefined ? '_'+suffix : '')).val()];
	if(typeof(states) != 'undefined')
	{
		$(states).each(function (key, item){
			$('select#id_state'+(suffix !== undefined ? '_'+suffix : '')).append('<option value="'+item.id+'"'+ (idSelectedCountry == item.id ? ' selected="selected"' : '') + '>'+item.name+'</option>');
		});
		
		$('p.id_state'+(suffix !== undefined ? '_'+suffix : '')+':hidden').slideDown('slow');
	}
	else
		$('p.id_state'+(suffix !== undefined ? '_'+suffix : '')).hide();
		
}

function updateNeedIDNumber(suffix)
{
	var idCountry = parseInt($('select#id_country'+(suffix !== undefined ? '_'+suffix : '')).val());

	if ($.inArray(idCountry, countriesNeedIDNumber) >= 0)
		$('.dni'+(suffix !== undefined ? '_'+suffix : '')).slideDown('slow');
	else
		$('.dni'+(suffix !== undefined ? '_'+suffix : '')).slideUp('fast');
}

function updateZipCode(suffix)
{
	var idCountry = parseInt($('select#id_country'+(suffix !== undefined ? '_'+suffix : '')).val());
	
	if (countriesNeedZipCode[idCountry] != 0)
		$('.postcode'+(suffix !== undefined ? '_'+suffix : '')).slideDown('slow');
	else
		$('.postcode'+(suffix !== undefined ? '_'+suffix : '')).slideUp('fast');
}
