<?php
ob_start();
session_start();
require_once('config.php');
if($_SESSION['logged'] != 1 || !isset($_SESSION['uid'])) { header("Location: login.php"); }
// 'edit' päringu ümbertöötlemine //
if(isset($_POST['edit']))
{
	if(isset($_POST['pass']) || isset($_POST['email']))
	{
		$vead = '';
		$q = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE id = '.$_SESSION['uid'].''));
		if(!empty($_POST['pass']))
		{
			$old_pass = mysql_real_escape_string($_POST['old_pass']);
			$pass = mysql_real_escape_string($_POST['pass']);
			$pass2 = mysql_real_escape_string($_POST['pass2']);
			if(md5($old_pass) != $q['password']) { $vead.= 'Vana parool on vale!<br />'; }
			if($pass != $pass2) { $vead.= 'Uued paroolid ei ole samad!<br />'; }
		}
		if(!empty($_POST['email']))
		{
			$email = mysql_real_escape_string($_POST['email']);
			$email2 = mysql_real_escape_string($_POST['email2']);
			if($email != $email2) { $vead.= 'Uued meiliaadressid ei ole samad!<br />'; }
		}
		if(empty($vead))
		{
			echo "start";
			if(!empty($_POST['pass']) && !empty($_POST['email']))
			{
				echo "0";
				mysql_query("UPDATE users SET password = '".md5($pass)."', e-mail = '".$email."' WHERE id = ".$_SESSION['uid']."") or die (mysql_error());
			}
			elseif(!empty($_POST['pass']))
			{
				echo "1";
				mysql_query("UPDATE users SET password = '".md5($pass)."' WHERE id = ".$_SESSION['uid']."") or die (mysql_error());
			}
			elseif(!empty($_POST['email']))
			{
				echo "2";
				mysql_query("UPDATE users SET `e-mail` = '".$email."' WHERE id = ".$_SESSION['uid']."") or die (mysql_error());
			}
			$_SESSION['logged'] = false;
			$_SESSION['uid'] = 0;
			unset($_SESSION['uid']);
			unset($_SESSION['logged']);
			header('Location: index.php?page=login');
			echo '<meta http-equiv="refresh" content="0;url=index.php?page=login">';
		}
		else
		{
			echo '<div id="content"><div id="content-head">Veateade</div><div id="content-box">'.$vead.'</div></div><br>';
		}
	}
}
?>
<html>
<head>
<title>Staatus &bull; Konto</title>
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
          <td align="right">Kasutaja</td>
          <td><b><?php echo user($_SESSION['uid'], 'username'); ?></b></td>
        </tr>
	    <tr>
          <td colspan="2" align="center"><em>Meiliaadress</em></td>
        </tr>
        <tr>
          <td align="right">Praegune e-mail</td>
          <td><b><?php echo user($_SESSION['uid'], 'e-mail'); ?></b></td>
        </tr>
        <tr>
          <td align="right">Uus e-mail</td>
          <td><input type="text" name="email" /></td>
        </tr>
        <tr>
          <td align="right">Korda uus e-mail</td>
          <td><input type="text" name="email2" /></td>
        </tr>
	    <tr>
          <td colspan="2" align="center"><em>Parool</em></td>
        </tr>
        <tr>
          <td align="right">Praegune parool</td>
          <td><input type="text" name="old_pass" /></td>
        </tr>
        <tr>
          <td align="right">Uus parool</td>
          <td><input type="text" name="pass" /></td>
        </tr>
        <tr>
          <td align="right">Korda uus parool</td>
          <td><input type="text" name="pass2" /></td>
        </tr>
		<tr>
			<td align="center" colspan="2"><input type="submit" name="edit" value="Muuda andmed" /></td>
		</tr>
		<tr>
			<td align="center" colspan="2">See konto kehtib kõikides projektides, mis asub staatus.eu domeenil.</td>
		</tr>
		<tr>
			<td align="center" colspan="2"><a href="logout.php">Logi välja</a></td>
		</tr>
      </table></form>
    </td>
  </tr>
</table>
</body>
</html>