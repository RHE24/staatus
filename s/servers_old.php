<?php
//error_reporting(E_ALL);
if($SECRET_IDX_KEY != "IDX") header("Location: ./index.php");
/* SERVERITE KUVAJA */
$order['set'] = "SELECT * FROM ".$DB['prefix']."servers ORDER BY status DESC, premium DESC, server_players DESC, server_maxplayers DESC";

if(isset($_GET['column']) && isset($_GET['order']))
{
	if(empty($_GET['column']) || empty($_GET['order']))
	{
		echo '<meta http-equiv="refresh" content="0;url=?page=servers">';
	}
	$order['column'] = mysql_real_escape_string($_GET['column']);
	$order['order'] = mysql_real_escape_string($_GET['order']);
	if($order['order'] == "asc" || $order['order'] == "desc")
	{
		if($order['column'] == "players" || $order['column'] == "ratings" || $order['column'] == "records")
		{
			switch($order['column'])
			{
				case 'players':
					if($order['order'] == "desc") {
						$order['set'] = "SELECT * FROM ".$DB['prefix']."servers ORDER BY status DESC, premium DESC, server_players DESC";
					}else{
						$order['set'] = "SELECT * FROM ".$DB['prefix']."servers ORDER BY status DESC, premium DESC, server_players ASC";
					}
				break;
				case 'ratings': // võtta tabelist ratings hinnanguid ja liita kokku ning järjestada hinnangu järgi
					if($order['order'] == "desc") {
						$order['set'] = "SELECT *, (SELECT SUM(rating) FROM ".$DB['prefix']."ratings WHERE ".$DB['prefix']."ratings.server_id = ".$DB['prefix']."servers.id) AS totalRating FROM ".$DB['prefix']."servers ORDER BY status DESC, premium DESC, totalRating DESC";
					}else{
						$order['set'] = "SELECT *, (SELECT SUM(rating) FROM ".$DB['prefix']."ratings WHERE ".$DB['prefix']."ratings.server_id = ".$DB['prefix']."servers.id) AS totalRating FROM ".$DB['prefix']."servers ORDER BY status DESC, premium DESC, totalRating ASC";
					}
				break;
				case 'records':
					if($order['order'] == "desc") {
						$order['set'] = "SELECT * FROM ".$DB['prefix']."servers ORDER BY status DESC, premium DESC, server_maxplayers DESC";
					}else{
						$order['set'] = "SELECT * FROM ".$DB['prefix']."servers ORDER BY status DESC, premium DESC, server_maxplayers ASC";
					}
				break;
			}
		}
		else
		{
			echo '<meta http-equiv="refresh" content="0;url=?page=servers">';
		}
	}
	else
	{
		echo '<meta http-equiv="refresh" content="0;url=?page=servers">';
	}
}

if(isset($_GET['server_id']) && isset($_GET['rating']))
{
	if(empty($_GET['server_id']) || empty($_GET['rating']))
	{
		echo '<meta http-equiv="refresh" content="0;url=?page=servers">';
	}
	$input[0] = mysql_real_escape_string($_GET['server_id']);
	$input[1] = mysql_real_escape_string($_GET['rating']);
	$query6 = mysql_query('SELECT * FROM '.$DB['prefix'].'servers WHERE id = "'.$input[0].'"') or die(mysql_error());
	$n_o_r6 = mysql_num_rows($query6);
	if($n_o_r6 != 0)
	{
		$query7 = mysql_query('SELECT * FROM '.$DB['prefix'].'ratings WHERE user_id = "'.$_SESSION['uid'].'" AND server_id = "'.$input[0].'"') or die(mysql_error());
		$n_o_r7 = mysql_num_rows($query7);
		if($n_o_r7 == 0)
		{
			if($input[1] == "positive")
			{
				$rating = 1;
			} else {
				//$rating = -1; 
				echo 'Negatiivset hinnangu ei saa anda!';
				echo '<meta http-equiv="refresh" content="0;url=?page=servers">';
			}
			mysql_query('INSERT INTO `'.$DB['prefix'].'ratings` (`user_id`, `server_id`, `rating`, `date`, `IP`) VALUES ("'.$_SESSION['uid'].'", "'.$input[0].'", "'.$rating.'", "'.date("U").'", "'.$_SERVER['REMOTE_ADDR'].'")') or die(mysql_error());
			echo 'Täname! Sinu hinnang on lisatud.<br><meta http-equiv="refresh" content="1;url=?page=servers">';
		}
		else
		{
			echo 'Sa oled juba andnud sellele oma hinnangu!<br><meta http-equiv="refresh" content="1;url=?page=servers">';
		}
	}
	else
	{
		echo '<meta http-equiv="refresh" content="0;url=?page=servers">';
	}
}
?>
<div class="row-fluid">
        <div class="span12">
		
          <div class="row-fluid">
            <div class="span12">
              <h2>Mänguserverid</h2>
              <p>
<table class="table table-bordered">
<tr>
<th></th>
<th>Serverinimi</th>
<th>IP:Port</th>
<?php
if($_GET['column'] == "players" && $_GET['order'] == "desc")
{
	echo '<th>Mängijad&nbsp;<a href="?page=servers&column=players&order=asc"><img src="style/img/bullet_arrow_down.png" /></a></th>';
}
elseif($_GET['column'] == "players" && $_GET['order'] == "asc")
{
	echo '<th>Mängijad&nbsp;<a href="?page=servers&column=players&order=desc"><img src="style/img/bullet_arrow_up.png" /></a></th>';
}
else
{
	echo '<th><a href="?page=servers&column=players&order=desc">Mängijad</a></th>';
}
?>
<?php
if($_GET['column'] == "records" && $_GET['order'] == "desc")
{
	echo '<th>Rekordarv&nbsp;<a href="?page=servers&column=records&order=asc"><img src="style/img/bullet_arrow_down.png" /></a></th>';
}
elseif($_GET['column'] == "records" && $_GET['order'] == "asc")
{
	echo '<th>Rekordarv&nbsp;<a href="?page=servers&column=records&order=desc"><img src="style/img/bullet_arrow_up.png" /></a></th>';
}
else
{
	echo '<th><a href="?page=servers&column=records&order=desc">Rekordarv</a></th>';
}
?>
<?php
if($_GET['column'] == "ratings" && $_GET['order'] == "desc")
{
	echo '<th>Hinnang&nbsp;<a href="?page=servers&column=ratings&order=asc"><img src="style/img/bullet_arrow_down.png" /></a></th>';
}
elseif($_GET['column'] == "ratings" && $_GET['order'] == "asc")
{
	echo '<th>Hinnang&nbsp;<a href="?page=servers&column=ratings&order=desc"><img src="style/img/bullet_arrow_up.png" /></a></th>';
}
else
{
	echo '<th><a href="?page=servers&column=ratings&order=desc">Hinnang</a></th>';
}
?>
<th>Kaart</th>
</tr>
<?php            
$query = mysql_query(''.$order['set'].'') or die(mysql_error());
$number_of_rows = mysql_num_rows($query);            
if ($number_of_rows == 0){                
	echo '<tr>';                
	echo '<td colspan="8" align="center">Pole saadaval</td>';                
	echo '</tr>';            
} else {                
	while($row = mysql_fetch_array($query))                
	{                   
		if($row['status'] != 1)
		{
			echo '<tr class="error">';					
		}
		else
		{
			if($row['premium'] == 1)
			{
				echo '<tr class="warning">';	
			}
			else
			{
				echo '<tr>';
			}
		}
		$games_query = mysql_query("SELECT * FROM ".$DB['prefix']."games WHERE id = ".$row['game_id']."") or die(mysql_error());
		$games_sql = mysql_fetch_array($games_query);
		echo '<td align="center"><img src="'.$games_sql['img_path'].'" /></td>';
		$server_name = strlen($row['server_name']) > 32 ? substr($row['server_name'], 0, 32)."..." : $row['server_name'];
		echo '<td align="center"><a href="?page=serverinfo&server_id='.$row['id'].'">'.$server_name.'</a></td>'; 
		echo '<td align="center">'.$row['server_ip'].':'.$row['server_port'].'</td>';					
		echo '<td align="center">'.$row['server_players'].'/'.$row['server_slot'].'</td>';					
		echo '<td align="center">'.$row['server_maxplayers'].'</td>';		
		$query2 = mysql_query('SELECT SUM(rating) FROM '.$DB['prefix'].'ratings WHERE server_id = "'.$row['id'].'"') or die(mysql_error());
		while($row2 = mysql_fetch_array($query2))
		{
			$rating = 0;
			if(!empty($row2['SUM(rating)'])) { $rating = $row2['SUM(rating)']; }
			if($_SESSION['logged'] != true) {
				echo '<td align="center">'.$rating.'</td>';    
			}else{
				$query3 = mysql_query('SELECT * FROM '.$DB['prefix'].'ratings WHERE server_id = "'.$row['id'].'" AND user_id = "'.$_SESSION['uid'].'"') or die(mysql_error());
				$number_of_rows3 = mysql_num_rows($query3);            
				if($number_of_rows3 == 0)
				{             
					echo '<td align="center">'.$rating.' <a href="?page=servers&server_id='.$row['id'].'&rating=positive" id="no-decoration"><span class="button_positive">+</span></a><!--&nbsp;<a href="?page=servers&server_id='.$row['id'].'&rating=negative" id="no-decoration"><span class="button_negative">-</span></a>--></td>';    
				}
				else
				{
					echo '<td align="center">'.$rating.'</td>';
				}
			}
		}
		echo '<td align="center">'.$row['server_mapname'].'</td>';		
		echo "</tr>";               
	}            
}            
?>        
</table>    
			</p>
            </div><!--/span-->
          </div><!--/row-->
        </div><!--/span-->
      </div><!--/row-->