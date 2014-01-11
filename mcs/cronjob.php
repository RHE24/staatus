<?php
//error_reporting(E_ALL);
require 'config.php';
require 'MinecraftQuery.class.php';
$MC_query = new MinecraftQuery();
$query = mysql_query('SELECT * FROM '.$DB['prefix'].'servers ORDER BY id ASC') or die(mysql_error());
$number_of_rows = mysql_num_rows($query);
if($number_of_rows != 0)
{
    while($row = mysql_fetch_array($query))
    {
		if($row['last_update']+300 < date("U")) // 300
		{
			$CHECK = 0;
			try
			{
				$MC_query->Connect(''.$row['server_real_ip'].'', $row['server_query'], 1);
			}
			catch(MinecraftQueryException $e)
			{
				$CHECK = 1;
			}
			if($CHECK == 0)
			{ // OK
				$MC_info = $MC_query->GetInfo();
				$server_players = $MC_info['Players'];
				$server_slot = $MC_info['MaxPlayers'];
				$replacements = array(
					'§1' => '',
					'§2' => '',
					'§3' => '',
					'§4' => '',
					'§5' => '',
					'§6' => '',
					'§7' => '',
					'§8' => '',
					'§9' => '',
					'§0' => '',
					'§a' => '',
					'§b' => '',
					'§c' => '',
					'§d' => '',
					'§e' => '',
					'§l' => '',
					'§f' => ''
				);
				$server_name = utf8_encode($MC_info['HostName']);
				$server_name = str_replace(array_keys($replacements), $replacements, $server_name);
				/*$server_name = utf8_decode($server_name);*/
				$server_record = $row['server_maxplayers'];
				$server_version = $MC_info['Version'];
				if($server_players > $server_record)
				{
					mysql_query("UPDATE ".$DB['prefix']."servers SET status = 1, server_name = '".mysql_real_escape_string($server_name)."', server_players = ".$server_players.", server_maxplayers = ".$server_players.", server_mpdate = ".date("U").", server_slot = ".$server_slot.", server_version = '".$server_version."', last_update = ".date("U")." WHERE id = ".$row['id']."") or die(mysql_error());
				}
				else
				{
					mysql_query("UPDATE ".$DB['prefix']."servers SET status = 1, server_name = '".mysql_real_escape_string($server_name)."', server_players = ".$server_players.", server_slot = ".$server_slot.", server_version = '".$server_version."', last_update = ".date("U")." WHERE id = ".$row['id']."") or die(mysql_error());
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