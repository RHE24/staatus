<?php
if($_SESSION['logged'] == 1) { header("Location: index.php"); }
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

	if(isset($_POST['login']))
	{
		$IP = $_SERVER['REMOTE_ADDR'];
		$user = mysql_real_escape_string($_POST['kasutaja']);
		$password = mysql_real_escape_string($_POST['parool']);
		$q = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `username` = "'.$user.'" OR `e-mail` = "'.$user.'"'));
		$vead = '';
		if(empty($_POST['kasutaja'])){ $vead.= 'Kasutaja on sisestamata!<br />'; }
		if(md5($password) != $q['password']) { $vead.= 'Parool on vale!<br />'; }
		if(empty($vead)){
			$UNIX = date("U");
			$_SESSION['logged'] = true;
			$user_id = $q['id'];
			$_SESSION['uid'] = $user_id;
			$generate_cookie = base64_encode($user_id.generatePassword(rand(75, 100), 15).$user_id);
			$_SESSION['ses'] = $generate_cookie;
			$q = mysql_query('SELECT * FROM users WHERE id = "'.$_SESSION['uid'].'"') or die(mysql_error());
			mysql_query("UPDATE users SET lastlogin = '".$UNIX."', session = '".$generate_cookie."' WHERE id = '".$user_id."'") or die (mysql_error());
			//mysql_query('INSERT INTO `sms_logins` (`user_id`, `date`, `IP`) VALUES ("'.$user_id.'", "'.$UNIX.'", "'.$IP.'")') or die(mysql_error());
			header('Location: index.php');
			echo '<meta http-equiv="refresh" content="0;url=index.php">';
		}else{
			echo '<div id="content"><div id="content-head">Vead</div><div id="content-box">'.$vead.'</div></div><br>';
		}
	}
?>
<div class="row-fluid">
        <div class="span12">
		
          <div class="row-fluid">
            <div class="span12">
              <h2>Sisse logimine</h2>
              <p>
			  
		<form action="" method="post">
		<table style="font-size: 13px;">
			<tr>
				<td>Kasutaja/E-mail:</td>
				<td><input type="text" name="kasutaja"></td>
			</tr>
			<tr>
				<td>Parool:</td>
				<td><input type="password" name="parool"></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: center;"><button name="login" type="submit">Logi sisse</button></td>
			</tr>
		</table>
		</form>
		<br>
		Kas sa pole registreerinud endale kontot sellel lehel? <a href="http://a.staatus.eu/register.php">Vajuta siia</a>.
			</p>
            </div><!--/span-->
          </div><!--/row-->
        </div><!--/span-->
      </div><!--/row-->