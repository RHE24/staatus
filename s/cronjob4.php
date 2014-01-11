<?php
require 'config.php';
$query = mysql_query('SELECT * FROM '.$DB['prefix'].'servers WHERE premium = 1') or die(mysql_error());
$number_of_rows = mysql_num_rows($query);
if($number_of_rows != 0)
{
    while($row = mysql_fetch_array($query))
    {
		if($row['premium_end'] < date("U"))
		{
			mysql_query("UPDATE ".$DB['prefix']."servers SET premium = 0, premium_end = 0 WHERE id = '".$row['id']."'") or die(mysql_error());
			echo "Deleted ".$row['id']."<br>";
		}
    }
}
?>