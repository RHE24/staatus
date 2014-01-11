function gameOnChange()
{
	var GMID = $('#games').val();
	var selectedOption = $("#games option:selected");
	var dport = selectedOption.attr('server_port');
	var qport = selectedOption.attr('server_query');
	$('#server_portx').val(dport);
	$('#server_queryx').val(qport);
	var sharedport = selectedOption.attr('sharedport');
	if(sharedport=='1')
	{
		$('#query_port_lahter').hide();
	}
	else
	{
		$('#query_port_lahter').show();
	}
	//jagatudport="1"/"0"
	//$('#query_port_lahter').hide();
}
function addServerOnSubmit(e)
{
	if("" + jQuery.trim($('#games').val()) == '')
	{
		alert('Palun vali mäng');
		return false;
	}
	$('#server-ip').val("" + jQuery.trim($('#server-ip').val()))
	$('#server_portx').val("" + jQuery.trim($('#server_portx').val()))
	$('#server_queryx').val("" + jQuery.trim($('#server_queryx').val()))
	if(!checkPort($('#server_portx').val()))
	{
		alert('Server port on valesti sisestatud!');
		$('#server_port').focus();
		return false;
	}
	if(!checkPort($('#server_queryx').val()))
	{
		alert('Query port on valesti sisestatud!');
		$('#server_queryx').focus();
		return false;
	}
	if($('#server-ip').val() == null || $('#server-ip').val()=='')
	{
		alert('Serveri IP väli on tühi, palun sisesta!');
		return false;
	}
	var ipAddress = document.getElementById('server-ip').value;
	var ipPattern = /^ *(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3}):\d+ *$/;
	var ipArray = ipAddress.match(ipPattern);
	if(ipArray != null)
	{
		alert('Sisestasid mõlema IP aadressi ja pordi IP välja. (Ainult IP vaja)');
		return false;
	}
	return true;
}

function checkPort(port)
{
	re = new RegExp("^[0-9]+$");
	if(!port.match(re))
		return false;
	if(port <= 1)
		return false;
	if(port > 65535)
		return false;
	return true;
}