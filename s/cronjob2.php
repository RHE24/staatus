<?php
require 'config.php';
//require 'MinecraftQuery.class.php';

require 'GameQ-2/GameQ.php';
$gq = new GameQ();
$servers = array();
//$MC_query = new MinecraftQuery();

$query = mysql_query('SELECT * FROM '.$DB['prefix'].'servers ORDER BY id ASC') or die(mysql_error());
$number_of_rows = mysql_num_rows($query);
if($number_of_rows != 0)
{
    while($row = mysql_fetch_array($query))
    {
		$server_info = ''.$row['server_real_ip'].':'.$row['server_query'].'';
		$games_query = mysql_fetch_array(mysql_query("SELECT * FROM ".$DB['prefix']."games WHERE id = '".$row['game_id']."'"));
		$server = array('id' => ''.$row['id'].'','type' => ''.$games_query['game'].'','host' => ''.$server_info.'');
		array_push($servers, $server);
	}
}

$gq->addServers($servers);
$gq->setFilter('normalise');
$results = $gq->requestData();

$query = mysql_query('SELECT * FROM '.$DB['prefix'].'servers ORDER BY id ASC') or die(mysql_error());
$number_of_rows = mysql_num_rows($query);
if($number_of_rows != 0)
{
    while($row = mysql_fetch_array($query))
    {
		$CHECK = 0;

		if(!$results[''.$row['id'].'']['gq_online']) {
			$CHECK = 1;
		} else {
			$CHECK = 0;	
		}

		if($CHECK == 0)
		{ // OK
			//$MC_info = $MC_query->GetInfo();
			//$server_players = $MC_info['Players'];
			$server_players = $results[''.$row['id'].'']['gq_numplayers'];
			switch(date("G:i"))
			{
				case '0:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", ".$server_players.")");break;}
				case '1:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", ".$server_players.")");break;}
				case '2:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", ".$server_players.")");break;}
				case '3:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", ".$server_players.")");break;}
				case '4:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", ".$server_players.")");break;}
				case '5:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", ".$server_players.")");break;}
				case '6:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", ".$server_players.")");break;}
				case '7:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", ".$server_players.")");break;}
				case '8:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", ".$server_players.")");break;}
				case '9:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", ".$server_players.")");break;}
				case '10:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", ".$server_players.")");break;}
				case '11:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", ".$server_players.")");break;}
				case '12:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", ".$server_players.")");break;}
				case '13:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", ".$server_players.")");break;}
				case '14:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", ".$server_players.")");break;}
				case '15:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", ".$server_players.")");break;}
				case '16:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", ".$server_players.")");break;}
				case '17:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", ".$server_players.")");break;}
				case '18:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", ".$server_players.")");break;}
				case '19:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", ".$server_players.")");break;}
				case '20:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", ".$server_players.")");break;}
				case '21:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", ".$server_players.")");break;}
				case '22:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", ".$server_players.")");break;}
				case '23:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", ".$server_players.")");break;}
			}
		}
		else
		{
			switch(date("G:i"))
			{
				case '0:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", 0)");break;}
				case '1:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", 0)");break;}
				case '2:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", 0)");break;}
				case '3:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", 0)");break;}
				case '4:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", 0)");break;}
				case '5:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", 0)");break;}
				case '6:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", 0)");break;}
				case '7:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", 0)");break;}
				case '8:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", 0)");break;}
				case '9:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", 0)");break;}
				case '10:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", 0)");break;}
				case '11:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", 0)");break;}
				case '12:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", 0)");break;}
				case '13:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", 0)");break;}
				case '14:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", 0)");break;}
				case '15:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", 0)");break;}
				case '16:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", 0)");break;}
				case '17:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", 0)");break;}
				case '18:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", 0)");break;}
				case '19:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", 0)");break;}
				case '20:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", 0)");break;}
				case '21:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", 0)");break;}
				case '22:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", 0)");break;}
				case '23:00': {mysql_query("INSERT INTO `".$DB['prefix']."players` (`server_id`, `unix`, `players`) VALUES (".$row['id'].", ".date("U").", 0)");break;}
			}
		}
    }
}
?>