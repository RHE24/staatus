<?php
error_reporting(E_ALL);
require 'config.php';

//require 'MinecraftQuery.class.php';
//$MC_query = new MinecraftQuery();

require 'GameQ-2/GameQ.php';
$gq = new GameQ();

$query = mysql_query('SELECT * FROM '.$DB['prefix'].'servers ORDER BY id ASC') or die(mysql_error());
$number_of_rows = mysql_num_rows($query);
if($number_of_rows != 0)
{
    while($row = mysql_fetch_array($query))
    {
		if($row['last_update']+300 < date("U")) // 300
		{
			$CHECK = 0;
			$server_info = ''.$row['server_real_ip'].':'.$row['server_query'].'';
			
			$games_query = mysql_fetch_array(mysql_query("SELECT * FROM ".$DB['prefix']."games WHERE id = '".$row['game_id']."'"));
			
			$server = array(array('id' => '','type' => ''.$games_query['game'].'','host' => ''.$server_info.'',));
			$gq->addServers($server);
			$gq->setFilter('normalise');
			$results = $gq->requestData();
			
			if(!$results[''.$server_info.'']['gq_online']) {
				$CHECK = 1;
			} else {
				$CHECK = 0;
			}
			
			if($CHECK == 0)
			{ // OK
				$server_players = $results[''.$server_info.'']['gq_numplayers'];
				$server_slot = $results[''.$server_info.'']['gq_maxplayers'];
				//echo $server_slot;
				$server_name = utf8_encode($results[''.$server_info.'']['gq_hostname']);
				if(!$results[''.$server_info.'']['gq_mapname'])
				{
					$server_mapname = $games_query['game_name'];
				} else {
					$server_mapname = $results[''.$server_info.'']['gq_mapname'];
				}
				$server_record = $row['server_maxplayers'];
				//$server_version = $MC_info['Version'];
				if($server_players > $server_record)
				{
					mysql_query("UPDATE ".$DB['prefix']."servers SET status = 1, server_name = '".$server_name."', server_players = ".$server_players.", server_maxplayers = ".$server_players.", server_mpdate = ".date("U").", server_slot = ".$server_slot.", server_mapname = '".$server_mapname."', last_update = ".date("U")." WHERE id = ".$row['id']."");
				}
				else
				{
					mysql_query("UPDATE ".$DB['prefix']."servers SET status = 1, server_name = '".$server_name."', server_players = ".$server_players.", server_slot = ".$server_slot.", server_mapname = '".$server_mapname."', last_update = ".date("U")." WHERE id = ".$row['id']."");
				}
			}
			else
			{ // FAILED
				mysql_query("UPDATE ".$DB['prefix']."servers SET status = 0, server_players = 0 WHERE id = ".$row['id']."");
			}
		}
		if($row['last_update']+604800 < date("U")) // 7 days
		{
			mysql_query("DELETE FROM ".$DB['prefix']."servers WHERE id = ".$row['id']."");
		}
    }
}
?>