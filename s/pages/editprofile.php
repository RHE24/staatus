<?php
if($SECRET_IDX_KEY != "IDX") header("Location: ./index.php");
if(isset($_POST['change_data']))
{
	$editprofile['nickname'] = mysql_real_escape_string($_POST['n_nickname']);
	$editprofile['interest'] = mysql_real_escape_string($_POST['n_interest']);
	$editprofile['occupation'] = mysql_real_escape_string($_POST['n_occupation']);
	$editprofile['homepage'] = mysql_real_escape_string($_POST['n_homepage']);
	mysql_query("UPDATE users SET nickname = '".$editprofile['nickname']."', interest = '".$editprofile['interest']."', occupation = '".$editprofile['occupation']."', homepage = '".$editprofile['homepage']."' WHERE id = '".$_SESSION['uid']."'") or die (mysql_error());
}
?>
<div class="row-fluid">
        <div class="span12">
		
          <div class="row-fluid">
            <div class="span8">
				<h2>Konto andmete muutmine (<?php echo user($_SESSION['uid'], 'username'); ?>)</h2>
				<p>
				<form action="" method="post">
					Staatus ID: <?php echo $_SESSION['uid']; ?><br>
					Hüüdnimi: <input type="text" name="n_nickname" value="<?php echo user($_SESSION['uid'], 'nickname'); ?>"><br>
					Huvi(d): <input type="text" name="n_interest" value="<?php echo user($_SESSION['uid'], 'interest'); ?>"><br>
					Elukutse: <input type="text" name="n_occupation" value="<?php echo user($_SESSION['uid'], 'occupation'); ?>"><br>
					Koduleht: <input type="text" name="n_homepage" value="<?php echo user($_SESSION['uid'], 'homepage'); ?>"><br>
				<button name="change_data" type="submit">Salvesta muudatused</button>
				</form>
				</p>
			</div><!--/row-->
		</div><!--/span-->
	</div><!--/row-->
</div>