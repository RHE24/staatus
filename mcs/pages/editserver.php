<?php
if($SECRET_IDX_KEY != "IDX") header("Location: ./index.php");
if($_SESSION['logged'] != true) { header("Location: index.php"); }
if(isset($_GET['s_id']) && !empty($_GET['s_id']))
{
$query = mysql_query('SELECT * FROM '.$DB['prefix'].'servers WHERE id = '.mysql_real_escape_string($_GET['s_id']).' AND submitter_id = '.$_SESSION['uid'].'') or die(mysql_error());
$number_of_rows = mysql_num_rows($query);
if ($number_of_rows != 0)
{
$query_info = mysql_fetch_assoc($query);
if(isset($_POST['change_data']))
{
	$info1 = utf8_encode(mysql_real_escape_string($_POST['info1_new']));
	$info2 = utf8_encode(mysql_real_escape_string($_POST['info2_new']));
	mysql_query("UPDATE ".$DB['prefix']."servers SET server_info1 = '".$info1."', server_info2 = '".$info2."' WHERE id = '".$_GET['s_id']."'") or die (mysql_error());
}
?>
<div id="content">
    <div id="content-head">Mänguserveri andmete muutmine</div>
	<div id="content-box">
		<form action="" method="post">
		<table style="font-size: 13px;">
			<tr>
				<td>Kodulehe aadress:</td>
				<td><input type="text" name="info1_new"<?php echo ' value="'.$query_info['server_info1'].'"'; ?>></td>
			</tr>
			<tr>
				<td>Informatsioon:</td>
				<td><input type="text" name="info2_new"<?php echo ' value="'.utf8_encode($query_info['server_info2']).'"'; ?>></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: center;"><button name="change_data" type="submit">Salvesta muudatused</button></td>
			</tr>
		</table>
		</form>
	</div>
</div>
<?php
}
else
{
	header("Location: ./index.php");
}
}
else
{
	header("Location: ./index.php");
} 
?>