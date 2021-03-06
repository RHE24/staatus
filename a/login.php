<?php
ob_start();
session_start();
/* Kontrollime, kas on sisselogitud */
if($_SESSION['logged'] == 1) { header("Location: index.php"); }

/* generatePassword funktsioon */
function generatePassword($length=9, $strength=0) {
	$vowels = 'aeuy';
	$consonants = 'bdghjmnpqrstvz';
	if ($strength & 1) {
		$consonants .= 'BDGHJLMNPQRSTVWXZ';
	}
	if ($strength & 2) {
		$vowels .= "AEUY";
	}
	if ($strength & 4) {
		$consonants .= '23456789';
	}
	if ($strength & 8) {
		$consonants .= '@#$%';
	}
 
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
}

/* 'login' päring POST meetodi abil */
if(isset($_POST['login']))
{
	/* Nõuame selle konfiguratsiooni sisu */
	require_once('config.php');
	global $con;
	
	$IP = $_SERVER['REMOTE_ADDR'];
	$user = mysql_real_escape_string($_POST['kasutaja']);
	$password = mysql_real_escape_string($_POST['parool']);
	$q = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `username` = "'.$user.'" OR `e-mail` = "'.$user.'"'));
	$vead = '';
	$password_check = hash('sha256', $password.$q['salt']);
	if(empty($_POST['kasutaja'])){ $vead.= 'Kasutaja on sisestamata!<br />'; }
	if($password_check != $q['password']) { $vead.= 'Parool on vale!<br />'; }
	if(empty($vead)){
		$UNIX = date("U");
		$_SESSION['logged'] = true;
		$user_id = $q['id'];
		$_SESSION['uid'] = $user_id;
		$generate_cookie = base64_encode($user_id.generatePassword(rand(75, 100), 15).$user_id);
		$_SESSION['ses'] = $generate_cookie;
		
		$stmt = $con->prepare('UPDATE users SET lastlogin = :unix, session = :generate_cookie WHERE id = :id');
		$stmt->execute(array(
			':id'   => $user_id,
			':lastlogin' => $UNIX,
			':generate_cookie' => $generate_cookie
		));
		
		header('Location: index.php');
		echo '<meta http-equiv="refresh" content="0;url=index.php">';
	}
	else
	{
		echo '<div id="content"><div id="content-head">Vead</div><div id="content-box">'.$vead.'</div></div><br>';
	}
}
?>
<html>
<head>
<title>Staatus &bull; Sisselogimine</title>
</head>
<style>
* {
	font-family: Verdana;
	font-size: 12px;
}
</style>
<body>
<table width="100%" height="100%">
  <tr height="100%">
    <td>
      <form method="post" action=""><table align="center">
	    <tr>
          <td colspan="2" align="center"><b>Staatus ID</b></td>
        </tr>
        <tr>
          <td align="right">Kasutaja/E-mail:</td>
          <td><input type="text" name="kasutaja" /></td>
        </tr>
        <tr>
          <td align="right">Parool:</td>
          <td><input type="password" name="parool" /></td>
        </tr>
		<tr>
			<td align="center" colspan="2"><input type="submit" name="login" value="Logi sisse" /></td>
		</tr>
		<tr>
			<td align="center" colspan="2"><a href="register.php">Registreerumine</a></td>
		</tr>
      </table></form>
    </td>
  </tr>
</table>
</body>
</html>