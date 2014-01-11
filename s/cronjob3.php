<?php
/*
	Aegunud serveri andmebaasist kustutamine
*/
require 'config.php';
require 'MinecraftQuery.class.php';
$MC_query = new MinecraftQuery();
$query = mysql_query('SELECT * FROM '.$DB['prefix'].'players ORDER BY id ASC') or die(mysql_error());
$number_of_rows = mysql_num_rows($query);
if($number_of_rows != 0)
{
    while($row = mysql_fetch_array($query))
    {
		$_time = 3888000; // 45 days
		$_unix = $_time + $row['unix'];
		if($row['unix'] > $_unix)
		{
			mysql_query("DELETE FROM ".$DB['prefix']."players WHERE id=".$row['id']."") or die(mysql_error());
			echo "Deleted ".$row['id']."<br>";
		}
    }
}
?>