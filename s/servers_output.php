<?php
header("Content-Type: image/png");
require 'config.php';
$serverid = array();
if(isset($_GET['game_id']))
{
	$query = mysql_query('SELECT * FROM '.$DB['prefix'].'servers WHERE status = 1 AND game_id = '.mysql_real_escape_string($_GET['game_id']).' ORDER BY server_players DESC, id ASC') or die(mysql_error());
}
else
{
	$query = mysql_query('SELECT * FROM '.$DB['prefix'].'servers WHERE status = 1 ORDER BY server_players DESC, id ASC') or die(mysql_error());
}
$number_of_rows = mysql_num_rows($query);
if($number_of_rows != 0)
{
	for($x=0; $x<=$number_of_rows; $x++)
	{
		while($row = mysql_fetch_array($query))
		{
			$serverid[] = array(
				"Name" => $row['server_name'],
				"IP" => $row['server_ip'],
				"Port" => $row['server_port'],
				"Players" => $row['server_players'],
				"MaxPlayers" => $row['server_maxplayers'],
				"Players" => $row['server_players'],
				"Slots" => $row['server_slot'],
				"Map" => $row['server_mapname']
			);
		}
	}
}
$yld=(2*9)*count($serverid);
$im = @imagecreate(720,$yld+15) or die("Cannot Initialize new GD image stream");
$background_color = imagecolorallocate($im, 255, 255, 255);
$text_color = imagecolorallocate($im, 0, 0, 0);
//print_r($serverid);
for($x=0; $x<count($serverid); $x++)
{
	$value = (2*9)*$x;
	$servername = strlen($serverid[$x]['Name']) > 32 ? substr($serverid[$x]['Name'], 0, 32)."..." : $serverid[$x]['Name'];
	//$text = "".$servername." | ".$serverid[$x]['Players']." | ".$serverid[$x]['MaxPlayers']." | ".$serverid[$x]['Players']." | ".$serverid[$x]['Slots']." | ".$serverid[$x]['Version']."";
	imagestring($im, 2, 3, $value, $x+1, $text_color);
	imagestring($im, 2, 20, $value, '| '.$servername.'', $text_color);
	imagestring($im, 2, 250, $value, '| '.$serverid[$x]['IP'].':'.$serverid[$x]['Port'].'', $text_color);
	imagestring($im, 2, 430, $value, '| Mängijad: '.$serverid[$x]['Players'].'/'.$serverid[$x]['Slots'].' ('.$serverid[$x]['MaxPlayers'].')', $text_color);
	imagestring($im, 2, 580, $value, '| Kaart: '.$serverid[$x]['Map'].'', $text_color);
}
imagestring($im, 2, 300-strlen("<< S.STAATUS.EU >>"), $yld, '<< S.STAATUS.EU >>', $text_color);
imagepng($im);
imagedestroy($im);
?>