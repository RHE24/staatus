<html>
<head>
   <style>
     div.pChartPicture { border: 0px; }
   </style>
</head>
<body>
   <script src="/pchart/imagemap.js" type="text/javascript"></script>
   <img src="chart.php" id="testPicture" alt="" class="pChartPicture"/>
</body>
<script>
   addImage("testPicture","pictureMap","chart.php?ImageMap=get");
</script>