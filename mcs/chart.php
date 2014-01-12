<?php
if(isset($_GET['server_id']))
{
	require_once 'config.php';
	$query = mysql_query('SELECT * FROM '.$DB['prefix'].'servers WHERE id = '.mysql_real_escape_string($_GET['server_id']).'') or die(mysql_error());
	$number_of_rows = mysql_num_rows($query);
	if($number_of_rows != 0)
	{
		$query_info = mysql_fetch_assoc($query);
		$INFO_SERVER_ID = $query_info['id'];
		$INFO_SERVER_IP = $query_info['server_ip'];
		$INFO_SERVER_PORT = $query_info['server_port'];
		$INFO_SERVER_NAME = $query_info['server_name'];
		$INFO_SERVER_SLOT = $query_info['server_slot'];
		/* Library settings */
		define("CLASS_PATH", "pchart/class");
		define("FONT_PATH", "pchart/fonts");
		/* pChart library inclusions */
		include(CLASS_PATH."/pData.class.php");
		include(CLASS_PATH."/pDraw.class.php");
		include(CLASS_PATH."/pImage.class.php");
		/* Create and populate the pData object */
		$MyData = new pData();
		$players_query = mysql_query('SELECT * FROM '.$DB['prefix'].'players WHERE server_id = '.mysql_real_escape_string($_GET['server_id']).' ORDER BY unix DESC LIMIT 28') or die(mysql_error());
		/*$MyData->addPoints(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),"mangijad");*/
		$array = array();
		$array2 = array();
		while($player = mysql_fetch_assoc($players_query)) {
			$array[] = $player['players'];
			$array2[] = date("G:i", $player['unix']);
		}
		$MyData->addPoints(array_reverse($array),"mangijad");

		$MyData->setSerieWeight("mangijad",0.5);
		$MyData->setAxisName(0,"Mängijate arv 24h jooksul");
		$MyData->addPoints(array_reverse($array2),"Labels");
		//$MyData->addPoints(array("20.09.2013","21.09.2013"), "Labels");
		$MyData->setAbscissa("Labels");
		/* Create the pChart object */
		$myPicture = new pImage(700,200,$MyData);
		/* Turn of Antialiasing */
		$myPicture->Antialias = FALSE;
		/* Draw the background */
		$Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107);
		$myPicture->drawFilledRectangle(0,0,700,200,$Settings);
		/* Overlay with a gradient */
		$Settings = array("StartR"=>219, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50);
		$myPicture->drawGradientArea(0,0,700,200,DIRECTION_VERTICAL,$Settings);
		/* Add a border to the picture */
		$myPicture->drawRectangle(0,0,699,199,array("R"=>0,"G"=>0,"B"=>0));
		/* Write the chart title */ 
		$myPicture->setFontProperties(array("FontName"=>FONT_PATH."/Forgotte.ttf","FontSize"=>11));
		$myPicture->drawText(200,35,$INFO_SERVER_NAME,array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));
		/* Set the default font */
		$myPicture->setFontProperties(array("FontName"=>FONT_PATH."/pf_arma_five.ttf","FontSize"=>6));
		/* Define the chart area */
		$myPicture->setGraphArea(30,35,690,180);
		$scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE,"Mode"=>SCALE_MODE_MANUAL,"ManualScale"=>array(0=>array("Min"=>0,"Max"=>$INFO_SERVER_SLOT)));
		$myPicture->drawScale($scaleSettings);
		/* Turn on Antialiasing */
		$myPicture->Antialias = TRUE;
		/* Draw the line chart */
		$Settings = array("RecordImageMap"=>TRUE);
		$myPicture->drawLineChart($Settings);
		//$myPicture->drawPlotChart(array("PlotBorder"=>FALSE,"BorderSize"=>0.1,"Surrounding"=>-20,"BorderAlpha"=>20));
		/* Render the picture (choose the best way) */
		$myPicture->stroke();
	}
}
?>