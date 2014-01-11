<?php if($SECRET_IDX_KEY != "IDX") header("Location: ./index.php");  ?>
<?php
if(isset($_POST['addserver']))
{
    require_once('recaptchalib.php');
    $privatekey = "6LedH98SAAAAAOKijuDWQ2rPuAOMRT4A4AzyusAH";
    $resp = recaptcha_check_answer($privatekey,
        $_SERVER["REMOTE_ADDR"],
        $_POST["recaptcha_challenge_field"],
        $_POST["recaptcha_response_field"]);
		
    $INFO_ip = mysql_real_escape_string($_POST['server_ip']);

    $check_IP_valid = filter_var($INFO_ip, FILTER_VALIDATE_IP);
	if($check_IP_valid == false)
	{
		$INFO_real_ip = gethostbyname($INFO_ip); // Ei tundu numbrilise IP'na
	}
	else
	{
		$INFO_real_ip = $INFO_ip; // Numbriline IP
	}
	$INFO_port = mysql_real_escape_string($_POST['server_port']);
	$INFO_query = mysql_real_escape_string($_POST['server_query']);
    $INFO_submitter = $_SERVER['REMOTE_ADDR'];
	
    
    $vead = '';
    if(empty($INFO_ip)){ $vead.= 'Server IP sisestamata!<br />'; }
    if(empty($INFO_port)){ $vead.= 'Server port sisestamata!<br />'; }
	if(strlen($INFO_port) > 6){ $vead.= 'Server port on valesti sisestatud #1!<br />'; }
	if(strlen($INFO_query) > 6){ $vead.= 'Query port on valesti sisestatud #1!<br />'; }
	
	$check_port_valid = filter_var($INFO_port, FILTER_VALIDATE_INT);
	if($check_port_valid == false) { $vead.= 'Server port on valesti sisestatud #2!<br />'; }
	$check_port_valid2 = filter_var($INFO_query, FILTER_VALIDATE_INT);
	if($check_port_valid2 == false) { $vead.= 'Query port on valesti sisestatud #2!<br />'; }
	
    if(!$resp->is_valid) { $vead.= 'Turvakood ei ole õigesti sisestatud!<br />'; }
	
	$sqli_q = mysql_query('SELECT * FROM servers WHERE server_real_ip = "'.$INFO_real_ip.'" AND (server_port = "'.$INFO_port.'" OR server_query = "'.$INFO_query.'")') or die(mysql_error());

	$sqli_number_of_rows = mysql_num_rows($sqli_q);
    if($sqli_number_of_rows != 0) { $vead.= 'Selline mänguserver eksisteerib juba andmebaasis!<br />'; }

	
	require 'MinecraftQuery.class.php';
	$MC_query = new MinecraftQuery();
	
	try
	{
		$MC_query->Connect(''.$INFO_ip.'', $INFO_query, 1);
	}
	catch(MinecraftQueryException $e)
	{
		$CHECK = 1;
	}
	
	if($CHECK == 1) { $vead.= 'Süsteem ei saanud mänguserverilt päringut! (Server on maas?)<br />'; }
	
    if(empty($vead))
	{
        $UNIX = date("U");
		
		if($CHECK == 0)
		{ // OK
			$MC_info = $MC_query->GetInfo();
			$server_players = $MC_info['Players'];
			$server_slot = $MC_info['MaxPlayers'];
			$server_name = $MC_info['HostName'];
			mysql_query('INSERT INTO `servers` (`status`, `server_real_ip`, `server_ip`, `server_port`, `server_query`, `server_name`, `server_players`, `server_slot`, `server_maxplayers`, `server_mpdate`, `added`, `last_update`, `submitter_ip`) VALUES (1, "'.$INFO_real_ip.'", "'.$INFO_ip.'", "'.$INFO_port.'", "'.$INFO_query.'", "'.mysql_real_escape_string($server_name).'", "'.$server_players.'", "'.$server_slot.'", "'.$server_players.'", "'.$UNIX.'", "'.$UNIX.'", "'.$UNIX.'", "'.$INFO_submitter.'")') or die(mysql_error());
		}
        echo '<div id="content">';
        echo '<div id="content-head">Teade</div>';
        echo '<div id="content-box">Mänguserver on edukalt lisatud andmebaasi.<br /> Palun oota, sind suunatakse ümber.<br /><a href="?page=servers">Kas automaatne suunamine ei t&#246;&#246;ta? Vajuta siia.</a><br /><meta http-equiv="refresh" content="1;url=?page=servers"></div>';
        echo '</div><br />';
        $newly_created = 1;
    }else{
        echo '<div id="content" style="color:#8b0000;">';
        echo '<div id="content-head">Vead</div>';
        echo '<div id="content-box">'.$vead.'</div>';
        echo '</div><br />';
    }
}
?>
<div class="row-fluid">
        <div class="span12">
		
          <div class="row-fluid">
            <div class="span12">
              <h2>Uue mänguserveri lisamine</h2>
              <p>
			  
		Täida kõigest serveri informatsiooni kohta lahtrid ning pärast saatmist automaatselt kontrollitakse serveri andmed.<br>
		Tee kindlaks, et süsteem saaks su mänguserverilt päringut. Kuidas?<br>
		Fail "<b>server.properties</b>" peab sisaldama:<br>
		enable-query=<b>true</b><br>
		query.port=<b>(serveri port)</b><br>
		<br>Soovitav kasutaja teha enne serveri lisamist, kuna siis avaneb lisavõimalused.<br><br>
		<form action="" method="post">
			<table style="font-size: 13px;">
				<tr>
					<td>Server IP &nbsp;</td>
					<td><input type="text" size="17" name="server_ip" value="" /></td>
				</tr>
				<tr>
					<td>Server port &nbsp;</td>
					<td><input type="text" size="8" name="server_port" value="" /> (Default port on 25565)</td>
				</tr>
				<tr>
					<td>Query port &nbsp;</td>
					<td>query.port=<input type="text" size="8" name="server_query" value="" /> (Tavaliselt 25565)</td>
				</tr>
				<tr>
					<td>Teie IP aadress &nbsp;</td>
					<td><b><?php echo $_SERVER['REMOTE_ADDR']; ?></b></td>
				</tr>
				<tr>
				<td>Turvakood &nbsp;</td>
				<td>
					<?php
					require_once('recaptchalib.php');
					$publickey = "6LedH98SAAAAADT2dIbo5kvXfnjFzXb4LgHsO6GH";
					echo recaptcha_get_html($publickey);
					?>
				</td>
				</tr>
				<tr>
					<td style="text-align: center;" colspan="2"><br><input type="submit" class="button" value="Lisa" name="addserver" /></td>
				</tr>
			</table>
		</form>
		
			</p>
            </div><!--/span-->
          </div><!--/row-->
        </div><!--/span-->
      </div><!--/row-->