<?php
ob_start();
session_start();
/*
A.STAATUS.EU
*/
if($_SESSION['logged'] == 1) { header("Location: index.php"); }
// Funktsioon //
function randomPassword()
{
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
// 'register' päringu ümbertöötlemine
if(isset($_POST['register']))
{
	require 'config.php';
	// Getting data
	$IP = $_SERVER['REMOTE_ADDR'];
	$user = mysql_real_escape_string($_POST['kasutaja']);
	$email = mysql_real_escape_string($_POST['email']);
	$email2 = mysql_real_escape_string($_POST['email2']);
	$geneeritud_parool = mysql_real_escape_string(randomPassword());
	// Checking data
	$deny_user_array = array('admin', 'adminn', 'administrator', 'administraator', 'mode', 'moderator', 'moderaator', 'moder', 'reklaamjuht', 'tegevusjuht', 'demo', 'test', 'pede', 'munn', 'lits');
	// Getting data from mySQL
	$user_exists = mysql_query('SELECT * FROM `users` WHERE `username` = "'.$user.'"');
	$email_exists = mysql_query('SELECT * FROM `users` WHERE `e-mail` = "'.$email.'"');
	
	require_once('recaptchalib.php');
    $privatekey = "6LedH98SAAAAAOKijuDWQ2rPuAOMRT4A4AzyusAH";
    $resp = recaptcha_check_answer($privatekey,
        $_SERVER["REMOTE_ADDR"],
        $_POST["recaptcha_challenge_field"],
        $_POST["recaptcha_response_field"]);
	
	// Error count
	$errors = array();
	if(in_array($user, $deny_user_array)){ $errors[] = 'See kasutajanimi on keelatud!'; }
	if(!preg_match('/([a-zA-Z0-9_.-]+)@([a-zA-Z0-9-]+).([a-zA-Z0-9-.]+)/', $email)){ $errors[] = 'E-mail aadress peab õige olema!'; }
	
	if($email != $email2) { $errors[] = 'Emaili aadressid ei kattu!'; }
	if(strlen($user) < 1){ $errors[] = 'Kasutajanimi sisestamata!';}

	if(mysql_num_rows($user_exists) > 0) { $errors[] = 'Selline kasutaja juba eksisteerib!'; }
	if(mysql_num_rows($email_exists) > 0) { $errors[] = 'Selline email juba eksisteerib!'; }
	
	if(!$resp->is_valid) { $errors[] = 'Turvakood ei ole õigesti sisestatud!'; }
	
	$filter_email = filter_var($email, FILTER_VALIDATE_EMAIL);
	if($filter_email == false) { $errors[] = 'Selline email aadress ei sobi!'; }

	if (count($errors) > 0)
	{
		echo '<div id="content"><div id="content-head">Vead</div><div id="content-box">';
		foreach($errors as $error){ echo $error.'<br />'; }
		echo '</div></div><br />';
	}
	else
	{
		mysql_query('INSERT INTO `users` (`username`, `e-mail`, `password`, `IP`, `joindate`) VALUES ("'.$user.'", "'.$email.'", "'.md5($geneeritud_parool).'", "'.$IP.'", "'.date("U").'")') or die(mysql_error());
		//MEIL
		require 'class.phpmailer.php';
		$mail = new PHPMailer;
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'ec2-54-229-98-112.eu-west-1.compute.amazonaws.com';  // Specify main and backup server
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'no-reply@mcs.staatus.eu';                            // SMTP username
		$mail->Password = 'p4r00l';                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
		$mail->From = 'no-reply@mcs.staatus.eu';
		$mail->FromName = 'A.STAATUS.EU';
		$mail->addAddress($email);
		$mail->WordWrap = 50;
		$mail->Subject = 'Konto on loodud (a.staatus.eu)';
		$mail->Body    = 'Kasutaja: '.strip_tags($_POST['kasutaja']).' | Parool: '.strip_tags($geneeritud_parool).' | Täname, et registreerusite meie lehel!';
		if(!$mail->send()) {
		   echo 'Süsteemi viga: Meili saatmisel tekkis veatõrge. Palun kontakteeru martin@prica.eu (meili teel).';
		   //echo 'Mailer Error: ' . $mail->ErrorInfo;
		   //exit;
		}
		//MEIL
		echo '<meta http-equiv="refresh" content="2;url=./"><div id="content"><div id="content-head">Teade</div><div id="content-box">';
		echo 'Kasutaja on loodud!<br /> Palun oota. Sind suunatakse automaatselt lehele.<br /> Kas automaatne suunamine ei t&#246;&#246;ta? <a href="./" style="color: black;">Vajuta siia</a>.';
		echo '</div></div><br />';
	}
}
?>
<html>
<head>
<title>Staatus &bull; Registreerumine</title>
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
          <td><input type="text" name="kasutaja" /></td>
        </tr>
        <tr>
          <td align="right">E-mail</td>
          <td><input type="text" name="email" /></td>
        </tr>
        <tr>
          <td align="right">Korda e-mail</td>
          <td><input type="text" name="email2" /></td>
        </tr>
        <tr>
          <td align="right">Turvakood</td>
          <td>
		<?php
				require_once('recaptchalib.php');
				$publickey = "6LedH98SAAAAADT2dIbo5kvXfnjFzXb4LgHsO6GH";
				echo recaptcha_get_html($publickey);
		?>
		  </td>
        </tr>
		<tr>
			<td align="center" colspan="2"><input type="submit" name="register" value="Registreeru" /></td>
		</tr>
		<tr>
			<td align="center" colspan="2">Pärast registreerumist geneeritud parool saadetakse teie meiliaadressile.</td>
		</tr>
		<tr>
			<td align="center" colspan="2"><a href="login.php">Sisselogimine</a></td>
		</tr>
      </table></form>
    </td>
  </tr>
</table>
</body>
</html>