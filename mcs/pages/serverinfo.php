<?php if($SECRET_IDX_KEY != "IDX") header("Location: ./index.php");  ?>
<?php
if(isset($_GET['server_id']))
{
$query = mysql_query('SELECT * FROM '.$DB['prefix'].'servers WHERE id = '.mysql_real_escape_string($_GET['server_id']).'') or die(mysql_error());
$number_of_rows = mysql_num_rows($query);
if ($number_of_rows != 0)
{
$query_info = mysql_fetch_assoc($query);
$INFO_SERVER_ID = $query_info['id'];
$INFO_SERVER_REAL_IP = $query_info['server_real_ip'];
$INFO_SERVER_IP = $query_info['server_ip'];
$INFO_SERVER_PORT = $query_info['server_port'];
$INFO_SERVER_QUERY = $query_info['server_query'];
$INFO_SERVER_NAME = $query_info['server_name'];
$INFO_SERVER_PLAYERS = $query_info['server_players'];
$INFO_SERVER_SLOT = $query_info['server_slot'];
$INFO_SERVER_REKORDARV = $query_info['server_maxplayers'];
$INFO_SERVER_REKORDARV_AEG = $query_info['server_mpdate'];
$INFO_SUBMITTER_ID = $query_info['submitter_id'];
$INFO_PREMIUM = $query_info['premium'];
$INFO_PREMIUM_END = $query_info['premium_end'];

	if(isset($_POST['kommenteerimine']) & $_SESSION['logged'] == true)
	{
		$kommentaar = mysql_real_escape_string($_POST['kommentaar']);
		$IP = $_SERVER['REMOTE_ADDR'];
		$UNIX = date("U");
		$vead = '';
		if(empty($_POST['kommentaar'])){ $vead.= 'Komentaar sisestamata!<br />'; }
		if(empty($vead)){
			mysql_query('INSERT INTO `'.$DB['prefix'].'comments` (`server_id`, `user_id`, `IP`, `date`, `comment`) VALUES ("'.$INFO_SERVER_ID.'", "'.$_SESSION['uid'].'", "'.$IP.'", "'.$UNIX.'", "'.$kommentaar.'")') or die(mysql_error());
			echo '<meta http-equiv="refresh" content="0">';
		}else{
			echo '<div id="content"><div id="content-head">Veateate</div><div id="content-box">'.$vead.'</div></div><br>';
		}
	}
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
 
jQuery(document).ready(function(){
	
    jQuery('.s_h_query').live('click', function(event) {        
         jQuery('#query-box').toggle('show');
    });
});
 
</script>
<div class="row-fluid">
        <div class="span12">
		
          <div class="row-fluid">
            <div class="span8">
              <h2>Mänguserver</h2>
              <p>

    <?php
	if($query_info['submitter_id'] == $_SESSION['uid'])
	{
		echo '<div style="float:right;text-align:left;"><a href="index.php?page=editserver&s_id='.$INFO_SERVER_ID.'">MUUDA ANDMED</a></div>';
	}
	?>
	<?php if($INFO_PREMIUM == 1) { echo '<b>Server on preemium</b> ning preemiumi lõppemisaeg on '.date("H:i d/m/Y", $INFO_PREMIUM_END).'.<br>'; } ?>
	<b>Serveri nimi:</b> <?php echo utf8_encode($INFO_SERVER_NAME); ?><br>
	<b>Server:</b> <?php echo $INFO_SERVER_IP; ?>:<?php echo $INFO_SERVER_PORT; ?><br>
	<b>Mängijate arv onlainis:</b> <?php echo $INFO_SERVER_PLAYERS; ?>/<?php echo $INFO_SERVER_SLOT; ?><br>
	<b>Mängijate rekordarv:</b> <?php echo $INFO_SERVER_REKORDARV; ?> (<?php echo date("H:i d/m/Y", $INFO_SERVER_REKORDARV_AEG); ?>)<br>
	<b>Viimati uuendatud:</b> <?php echo date("H:i d/m/Y", $query_info['last_update']); ?><br>
	<b>Lisaja:</b> <?php if(!empty($INFO_SUBMITTER_ID)) { echo '<a href="?page=profile&user_id='.$INFO_SUBMITTER_ID.'">'.user($INFO_SUBMITTER_ID, 'username').'</a>'; } else { echo 'Külaline (Server on sinu oma? Kontakteeru MCS.STAATUS.EU toega, lisaks tõestus on vajalik)'; } ?><br>
	<?php
	if(!empty($query_info['server_info1']))
	{
		echo '<b>Serveri koduleht:</b> '.$query_info['server_info1'].'<br>';
	}
	if(!empty($query_info['server_info2']))
	{
		echo '<b>Informatsioon:</b><br>'.utf8_encode($query_info['server_info2']).'<br>';
	}
	?>
	<br><center><img src="http://mcs.staatus.eu/chart.php?server_id=<?php echo $INFO_SERVER_ID; ?>"><br><br>
	<span style="border: 1px solid grey; background-color: lightgrey; padding: 2px; border-radius: 5px;">[IMG]http://mcs.staatus.eu/chart.php?server_id=<?php echo $INFO_SERVER_ID; ?>[/IMG]</span></center><br>
	<br>
	</div>
	<div class="span4">
              <p>
	<div id="comments">
	<b>Kommentaarid</b><br>
	<?php            
		$query2 = mysql_query('SELECT * FROM '.$DB['prefix'].'comments WHERE server_id = '.$INFO_SERVER_ID.' ORDER BY id DESC LIMIT 20') or die(mysql_error());
		$number_of_rows = mysql_num_rows($query2);            
		if($number_of_rows != 0)
		{                            
			while($row = mysql_fetch_array($query2))                
			{                   
				echo '['.date("d/m/Y H:i", $row['date']).'] <a href="?page=profile&user_id='.$row['user_id'].'">'.user($row['user_id'], 'username').'</a>: '.$row['comment'].'<br>';       
			}            
		}
		else
		{
			echo "Ole esimene kommenteerija!<br>";
		}
	?>
	<?php if($_SESSION['logged'] == true) { ?>
	<br>
		<form action="" method="post">
			<table style="font-size: 13px;">
				<tr>
					<td>Kommentaar:</td>
					<td><textarea name="kommentaar" style="font-size:13px;"></textarea></td>
					<td style="text-align: center;"><button name="kommenteerimine" type="submit">Saada</button></td>
				</tr>
			</table>
		</form>
	</div>
	<?php } ?>
	
	</div>
	
	<!--<br><a href="#" class="s_h_query" style="text-decoration: none;">Näita/Peida serveri informatsioon</a><br>-->
	</p></div></div>
	
	<div id="query-box">
		<?php
		require 'MinecraftQuery.class.php';

		$Query = new MinecraftQuery( );

		try
		{
		$Query->Connect( ''.$INFO_SERVER_REAL_IP.'', $INFO_SERVER_QUERY, 1 );
		}
		catch( MinecraftQueryException $e )
		{
		$Error = $e->getMessage( );
		}

		if( isset( $Error ) ): ?>
		Exception:
		<?php echo htmlspecialchars( $Error ); ?>
		
		<?php else: ?>
		<div class="row-fluid">
			<div class="span8">
				<table class="table table-bordered">
				<thead>
				<tr>
				<th colspan="2">Serveri informatsioon</th>
				</tr>
				</thead>
				<tbody>
				<?php if( ( $Info = $Query->GetInfo( ) ) !== false ): ?>
				<?php foreach( $Info as $InfoKey => $InfoValue ): ?>
				<tr>
				<td><?php echo htmlspecialchars( $InfoKey ); ?></td>
				<td><?php
				if( Is_Array( $InfoValue ) )
				{
				echo "<pre>";
				print_r( $InfoValue );
				echo "</pre>";
				}
				else
				{
				echo htmlspecialchars( $InfoValue );
				}
				?></td>
				</tr>
				<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
				</table>
			</div>
			<div class="span4">
				<table class="table table-bordered">
				<thead>
				<tr>
				<th>Mängijad</th>
				</tr>
				</thead>
				<tbody>
				<?php if( ( $Players = $Query->GetPlayers( ) ) !== false ): ?>
				<?php foreach( $Players as $Player ): ?>
				<tr>
				<td><?php echo htmlspecialchars( $Player ); ?></td>
				</tr>
				<?php endforeach; ?>
				<?php else: ?>
				<tr>
				<td>Serveris pole mängijaid.</td>
				</tr>
				<?php endif; ?>
				</tbody>
				</table>
			</div>
		</div>
		<?php endif; ?>
	</div>
	
			</p>

          </div><!--/row-->
        </div><!--/span-->
      </div><!--/row-->
<?php
}}
else
{
	header("Location: ./index.php");
} 
?>