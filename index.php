<?php include("config/net.php");?>
<?php
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE HTML>

<html>
    <head>
		<?php include("template/meta.php");?>        
	</head>
	<body class="is-preload">		
		<?php 
            include("template/header.php");  
            include("engine.php");
            include("template/footer.php");             
            include("template/libs.php");     
        ?>
	</body>
</html>