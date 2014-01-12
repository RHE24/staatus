<?php
if($SECRET_IDX_KEY != "IDX") { header("Location: ./index.php"); }
if($_SESSION['logged'] != true) { header("Location: index.php"); }
?>
<div class="row-fluid">
        <div class="span12">
		
          <div class="row-fluid">
            <div class="span12">
              <h2>Minu mänguserverid</h2>
				
				<p>Soovid, et sinu server oleks nimekirja tipus teatud aja? Selleks saada SMS sisuga "<span style="font-weight: bold;">FOR SST <span style="color: red; font-weight: bold;">server ID</span></span>" numbrile <b>13011</b>. Teenus maksab 0,64 EUR ning ajapikkus on 1 nädal.
				
				<table class="table table-bordered">
<tr>
<th>Staatus</th>
<th>Server ID</th>
<th>Serverinimi</th>
<th>Server:Port</th>
<th>Mängijad</th>
<th>Rekordarv</th>
<th>Viimati uuendatud</th>
</tr>
<?php            
$query = mysql_query('SELECT * FROM '.$DB['prefix'].'servers WHERE submitter_id = '.$_SESSION['uid'].' ORDER BY status DESC, server_players DESC, server_maxplayers DESC') or die(mysql_error());
$number_of_rows = mysql_num_rows($query);            
if ($number_of_rows == 0){                
echo '<tr>';                
echo '<td colspan="6" align="center">Pole saadaval</td>';                
echo '</tr>';            
} else {                
while($row = mysql_fetch_array($query))                
{                   
echo '<tr>';		
echo '<td align="center">'.($row['status'] == 1 ? '<span style="color:green;">Sees</span>' :  '<span style="color:red;">Väljas</span>').'</td>';
echo '<td align="center">'.$row['id'].'</td>';	
echo '<td align="center"><a href="?page=serverinfo&server_id='.$row['id'].'">'.(strlen($row['server_name']) > 32 ? substr($row['server_name'], 0, 32)."..." : $row['server_name']).'</a></td>'; 
echo '<td align="center">'.$row['server_ip'].':'.$row['server_port'].'</td>';		
echo '<td align="center">'.$row['server_players'].'/'.$row['server_slot'].'</td>';		
echo '<td align="center">'.$row['server_maxplayers'].'</td>';		
echo '<td align="center">'.date("H:i d/m/Y", $row['last_update']).'</td>';                    
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