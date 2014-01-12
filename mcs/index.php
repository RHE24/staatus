<?php
ob_start();
session_start();
require 'config.php';
$SECRET_IDX_KEY = ("IDX");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Staatus &bull; Minecraft serverid</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Minecraft servers">
    <meta name="author" content="Martin Vooremäe">

    <!-- Le styles -->
    <link href="style/css/bootstrap.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700' rel='stylesheet' type='text/css'>
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
		font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
      }
      .sidebar-nav {
        padding: 9px 0;
      }

      @media (max-width: 980px) {
        /* Enable use of floated navbar text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
    </style>
    <link href="style/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="style/js/html5shiv.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="?page=index">Minecraft</a>
          <div class="nav-collapse collapse">
            <!--<p class="navbar-text pull-right">
              Logged in as <a href="#" class="navbar-link">Username</a>
            </p>-->
			<p class="navbar-text pull-right">
			<?php if($_SESSION['logged'] == true) { ?><a href="?page=profile">Profiil</a><?php } ?>
			<?php if($_SESSION['logged'] != true) { ?><a href="?page=login">Logi sisse</a><?php } ?>
			<?php if($_SESSION['logged'] == true) { ?><a href="?page=logout">Logi välja</a><?php } ?>
			</p>
            <ul class="nav">
              <li><a href="?page=servers">Mänguserverid</a></li>
			  <?php if($_SESSION['logged'] == true) { ?><li><a href="?page=addserver2">Lisa mänguserver</a></li><?php } ?>
			  <?php if($_SESSION['logged'] == true) { ?><li><a href="?page=myservers">Minu mänguserverid</a></li><?php } ?>
              <li><a href="?page=hosters">Teenusepakkujad</a></li>
			  <li><a href="?page=statistics">Statistika</a></li>
			  <li><a href="http://chat.staatus.eu">Jututuba</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
<div id="body-wrap">
    <div class="container-fluid">
	<div class="row-fluid">
        <div class="span12">
      <?php
        switch(@$_GET['page'])
        {
            default:
                if(empty($_GET['page']))
                {
                    include './pages/servers.php';
                }
                else
                {
                    $pag = explode('/pages/', $_GET['page']);
                    if(file_exists('./pages/'.end($pag).'.php') == true)
                    {
                        include './pages/'.end($pag).'.php';
                    }
                    else
                    {
                        echo '<div id="content" style="color:#8b0000;font-family:Arial;">';
                        echo '<div id="content-head">404 - Not found</div>';
                        echo '<div id="content-box">Lehte ei leitud!</div>';
                        echo '</div>';
                    }
                }
            break;
			case 'index':
				include './pages/servers.php';
			break;
            case 'logout':
                //include 'logoff.php';
				$_SESSION['logged'] = false;
				$_SESSION['uid'] = 0;
				header("Location: index.php");
				echo '<meta http-equiv="refresh" content="0;url=index.php">'; 
            break;
        }
        ?>

      <hr>

      <footer>
        <p><?php echo date("H:i:s d/m/Y", date("U")); ?> &bull; <?php echo date("U"); ?> <?php if($_SESSION['logged'] == true) echo '&bull; '.$_SESSION['uid'].' &bull; <a style="color:gray;" href="?page=changepw">Parooli vahetamine</a>'; ?> &bull; Tugi <b>info@prica.ee</b></p>
      </footer>
</div><!--/span-->
      </div><!--/row-->
    </div><!--/.fluid-container-->
</div>
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="style/js/jquery.js"></script>
	<script src="style/js/bootstrap.js"></script>
    <script src="style/js/bootstrap-transition.js"></script>
    <script src="style/js/bootstrap-alert.js"></script>
    <script src="style/js/bootstrap-modal.js"></script>
    <script src="style/js/bootstrap-dropdown.js"></script>
    <script src="style/js/bootstrap-scrollspy.js"></script>
    <script src="style/js/bootstrap-tab.js"></script>
    <script src="style/js/bootstrap-tooltip.js"></script>
    <script src="style/js/bootstrap-popover.js"></script>
    <script src="style/js/bootstrap-button.js"></script>
    <script src="style/js/bootstrap-collapse.js"></script>
    <script src="style/js/bootstrap-carousel.js"></script>
    <script src="style/js/bootstrap-typeahead.js"></script>
	
  </body>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-46668937-1', 'staatus.eu');
  ga('send', 'pageview');

</script>
</html>
