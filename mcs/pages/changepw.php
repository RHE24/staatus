<?php if($SECRET_IDX_KEY != "IDX") header("Location: ./index.php");
if($_SESSION['logged'] != true) { header("Location: index.php"); } ?>
<?php
	if(isset($_POST['change_pw']))
	{
		$old_pass = mysql_real_escape_string($_POST['old_pass']);
		$new_pass = mysql_real_escape_string($_POST['new_pass']);
		$q = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE id = '.$_SESSION['uid'].''));
		$vead = '';
		if(md5($old_pass) != $q['password']) { $vead.= 'Vana parool on vale!<br />'; }
		if(empty($vead)){
			mysql_query("UPDATE users SET password = '".md5($new_pass)."' WHERE id = '".$_SESSION['uid']."'") or die (mysql_error());
			$_SESSION['logged'] = false;
			unset($_SESSION['uid']);
			unset($_SESSION['logged']);
			header('Location: index.php?page=login');
			echo '<meta http-equiv="refresh" content="0;url=index.php?page=login">';
		}else{
			echo '<div id="content"><div id="content-head">Veateate</div><div id="content-box">'.$vead.'</div></div><br>';
		}
	}
?>
<div id="content">
    <div id="content-head">Parooli vahetamine</div>
    <div id="content-box">
		<form action="" method="post">
		<table style="font-size: 13px;">
			<tr>
				<td>Vana parool:</td>
				<td><input type="password" name="old_pass"></td>
			</tr>
			<tr>
				<td>Uus parool:</td>
				<td><input type="password" name="new_pass"></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: center;"><button name="change_pw" type="submit">Salvesta</button></td>
			</tr>
		</table>
		</form>
	</div>
</div>