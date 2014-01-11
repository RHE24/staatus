<?php
if(isset($_GET['server_id']))
{
include 'config.php';
$query = mysql_query('SELECT * FROM players WHERE server_id = '.mysql_real_escape_string($_GET['server_id']).' ORDER BY unix DESC') or die(mysql_error());
$number_of_rows = mysql_num_rows($query);
if($number_of_rows != 0)
{
    while($row = mysql_fetch_array($query))
    {
		echo date("G:i", $row['unix']);
		echo ' - ';
		echo $row['players'];
		echo '<br>';
	}
}
}
?>