<?php
$CONFIG_DB['server'] = "localhost";
$CONFIG_DB['name'] = "staatus";
$CONFIG_DB['user'] = "staatus";
$CONFIG_DB['password'] = '';
$DB['prefix'] = "s_";
$CONFIG_DB['error_report'] = 0;

if($CONFIG_DB['error_report'] == 0) {
    mysql_connect($CONFIG_DB['server'], $CONFIG_DB['user'], $CONFIG_DB['password']) or die("<h1>ERROR</h1>Veebilehel esines viga ning sellest veast on teatatud administraatorile.");
    mysql_select_db($CONFIG_DB['name']) or die("<h1>ERROR</h1>Veebilehel esines viga ning sellest veast on teatatud administraatorile.");
} else {
    mysql_connect($CONFIG_DB['server'], $CONFIG_DB['user'], $CONFIG_DB['password']) or die(mysql_error());
    mysql_select_db($CONFIG_DB['name']) or die(mysql_error());
}

unset($CONFIG_DB['password']);

function user($uid, $col)
{
	$query = mysql_fetch_assoc(mysql_query('SELECT * FROM users WHERE id = "'.$uid.'" LIMIT 1'));
	return $query[$col];
}
?>