<?php
// Fortumo Ć¼henduse kontroll
if(!in_array($_SERVER['REMOTE_ADDR'],
	array('81.20.151.38', '81.20.148.122', '79.125.125.1', '209.20.83.207', '79.125.5.205', '79.125.5.95'))) {
	header("HTTP/1.0 403 Forbidden");
	die("Error: Unknown IP");
}

require 'config.php';

$message[0] = mysql_real_escape_string($_GET['message']);

$query = mysql_query('SELECT * FROM '.$DB['prefix'].'servers WHERE id = "'.$message[0].'"') or die(mysql_error());
        
// Kontroll, et kas selline Service ID eksisteerib meie andmebaasis
if(mysql_num_rows($query) != 0) // Eksisteerib
{
	while($row = mysql_fetch_array($query)) // Teostan skriptitĆ¶Ć¶
	{
		$UNIX = date("U");
		$end = $UNIX + 604800;
		mysql_query("UPDATE ".$DB['prefix']."servers SET premium = 1, premium_end = '".$end."' WHERE id = '".$message[0]."'") or die (mysql_error());
		$REPLY = "Täname sõnumi eest! Server ID ".$message[0]." on nüüd preemium! (nimekirja tipus)";
	}
} 
else 
{
	$REPLY = "#MCS.STAATUS.EU# Esines viga. Sellise ID'ga serverit ei leitud.";
}
// SĆµnumi vĆ¤ljasaatmine
echo($REPLY);
?>