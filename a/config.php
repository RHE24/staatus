<?php
/* Nõuame üldise konfiguratsiooni sisu */
require_once('../config.php');

$CONFIG_DB['error_report'] = 0;

function user($uid, $col)
{
	global $con;
	$query = $con->prepare('SELECT * FROM users WHERE id = :id');
	$query->execute(array('id' => $uid));
	while($row = $query->fetch(PDO::FETCH_ASSOC)) {
		return $row[$col];
	}
}
?>