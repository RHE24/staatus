<?php
if($SECRET_IDX_KEY != "IDX") header("Location: ./index.php");
/* PROFIIL */
if(isset($_GET['user_id']) && !empty($_GET['user_id']))
{
	$query = mysql_query('SELECT * FROM users WHERE id = '.mysql_real_escape_string($_GET['user_id']).'') or die(mysql_error());
	$number_of_rows = mysql_num_rows($query);
	if($number_of_rows != 0)
	{
		$profiil['id'] = mysql_real_escape_string($_GET['user_id']);
	}
	else
	{
		header("Location: ./index.php");
	} 
}
else
{
	$profiil['id'] = $_SESSION['uid'];
}
?>
<div class="row-fluid">
        <div class="span12">
		
          <div class="row-fluid">
            <div class="span6">
				<h2>Profiil (<?php echo user($profiil['id'], 'username'); ?>)</h2>
				<p>
					<?php if($_SESSION['uid'] == $profiil['id']) { ?><a href="?page=editprofile">Muuda andmed</a><br><?php } ?>
					Staatus ID: <?php echo $profiil['id']; ?><br>
					Liitus: <?php echo date("H:i d/m/Y", user($profiil['id'], 'joindate')); ?><br>
					Viimati aktiivne: <?php echo date("H:i d/m/Y", user($profiil['id'], 'lastlogin')); ?><br>
					Hüüdnimi: <?php $profiil['nickname'] = user($profiil['id'], 'nickname'); if(empty($profiil['nickname'])) { echo "Puudub"; } else { echo user($profiil['id'], 'nickname'); } ?><br>
					Huvi(d): <?php $profiil['interest'] = user($profiil['id'], 'interest'); if(empty($profiil['interest'])) { echo "Puudub"; } else { echo user($profiil['id'], 'interest'); } ?><br>
					Elukutse: <?php $profiil['occupation'] = user($profiil['id'], 'occupation'); if(empty($profiil['occupation'])) { echo "Puudub"; } else { echo user($profiil['id'], 'occupation'); } ?><br>
					Koduleht: <?php $profiil['homepage'] = user($profiil['id'], 'homepage'); if(empty($profiil['homepage'])) { echo "Puudub"; } else { echo '<a href="'.user($profiil['id'], 'homepage').'">'.user($profiil['id'], 'homepage').'</a>'; } ?><br>
				</p>
			</div><!--/row-->
			<div class="span6">
				<h2>Isiku poolt lisatud mänguserverid</h2>
				<p>
				<table class="table table-bordered">
<tr>
<th>Staatus</th>
<th>Serverinimi</th>
<th>Mängijad</th>
<th>Rekordarv</th>
<th>Versioon</th>
</tr>
<?php            
$query = mysql_query('SELECT * FROM '.$DB['prefix'].'servers WHERE submitter_id = '.$profiil['id'].' ORDER BY status DESC, server_players DESC, server_maxplayers DESC') or die(mysql_error());
$number_of_rows = mysql_num_rows($query);            
if ($number_of_rows == 0){                
echo '<tr>';                
echo '<td colspan="6" align="center">Pole</td>';                
echo '</tr>';            
} else {                
while($row = mysql_fetch_array($query))                
{                   
echo '<tr>';		
echo '<td align="center">'.($row['status'] == 1 ? '<span style="color:green;">Sees</span>' :  '<span style="color:red;">Väljas</span>').'</td>';
echo '<td align="center"><a href="?page=serverinfo&server_id='.$row['id'].'">'.(strlen($row['server_name']) > 32 ? substr($row['server_name'], 0, 32)."..." : $row['server_name']).'</a></td>'; 	
echo '<td align="center">'.$row['server_players'].'/'.$row['server_slot'].'</td>';		
echo '<td align="center">'.$row['server_maxplayers'].'</td>';		
echo '<td align="center">'.$row['server_version'].'</td>';                    
echo "</tr>";               
}            
}            
?>
</table>

				<h2>Isik kommenteeris</h2>
				<p>
				<table class="table table-bordered">
<tr>
<th>Kommentaar</th>
</tr>
<?php            
$query = mysql_query('SELECT * FROM '.$DB['prefix'].'comments WHERE user_id = '.$profiil['id'].' ORDER BY date DESC') or die(mysql_error());
$number_of_rows = mysql_num_rows($query);            
if ($number_of_rows == 0){                
echo '<tr>';                
echo '<td colspan="6" align="center">Pole</td>';                
echo '</tr>';            
} else {                
while($row = mysql_fetch_array($query))                
{                   
echo '<tr>';		
echo '<td align="center"><a href="?page=serverinfo&server_id='.$row['server_id'].'" style="text-decoration:none;">['.date("H:i d/m/Y", $row['date']).']</a> '.$row['comment'].'</td>';                    
echo "</tr>";               
}            
}            
?>
</table>
				</p>
			</div><!--/row-->
		</div><!--/span-->
	</div><!--/row-->
</div>