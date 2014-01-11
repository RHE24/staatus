<?php if($SECRET_IDX_KEY != "IDX") header("Location: ./index.php");  ?>
<div class="row-fluid">
        <div class="span12">
		
          <div class="row-fluid">
            <div class="span4">
              <h2>Statistika</h2>
              <p>
<table class="table table-bordered">
			<?php            
			$query = mysql_query('SELECT COUNT(*) AS value_sum FROM '.$DB['prefix'].'servers WHERE status = 1') or die(mysql_error());
			while($row = mysql_fetch_assoc($query))
			{
				echo '<tr>';
				echo '<td>';
				echo 'Serverid onlainis';
				echo '</td>';
				echo '<td>';
				echo $row['value_sum'];
				echo '</td>';
				echo '</tr>';
			}  
         
			$query = mysql_query('SELECT COUNT(*) AS value_sum FROM '.$DB['prefix'].'servers') or die(mysql_error());
			while($row = mysql_fetch_assoc($query))
			{
				echo '<tr>';
				echo '<td>';
				echo 'Serverid andmebaasis';
				echo '</td>';
				echo '<td>';
				echo $row['value_sum'];
				echo '</td>';
				echo '</tr>';
			}  
		 
			$query = mysql_query('SELECT SUM(server_players) AS value_sum FROM '.$DB['prefix'].'servers') or die(mysql_error());
			while($row = mysql_fetch_assoc($query))
			{
				echo '<tr>';
				echo '<td>';
				echo 'Mängijad onlainis';
				echo '</td>';
				echo '<td>';
				echo $row['value_sum'];
				echo '</td>';
				echo '</tr>';
			}
			
			$query = mysql_query('SELECT COUNT(*) AS value_sum FROM users') or die(mysql_error());
			while($row = mysql_fetch_assoc($query))
			{
				echo '<tr>';
				echo '<td>';
				echo 'Kasutajad andmebaasis';
				echo '</td>';
				echo '<td>';
				echo $row['value_sum'];
				echo '</td>';
				echo '</tr>';
			}
			
			$query = mysql_query('SELECT COUNT(*) AS value_sum FROM '.$DB['prefix'].'comments') or die(mysql_error());
			while($row = mysql_fetch_assoc($query))
			{
				echo '<tr>';
				echo '<td>';
				echo 'Kommentaarid andmebaasis';
				echo '</td>';
				echo '<td>';
				echo $row['value_sum'];
				echo '</td>';
				echo '</tr>';
			}
			
			$query = mysql_query('SELECT COUNT(*) AS value_sum FROM '.$DB['prefix'].'ratings') or die(mysql_error());
			while($row = mysql_fetch_assoc($query))
			{
				echo '<tr>';
				echo '<td>';
				echo 'Hinnanguid andmebaasis';
				echo '</td>';
				echo '<td>';
				echo $row['value_sum'];
				echo '</td>';
				echo '</tr>';
			}
			?>        
			</table>    
			</p>
            </div><!--/span-->
          </div><!--/row-->
        </div><!--/span-->
      </div><!--/row-->