<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<LINK href="css/style.css" rel="stylesheet" type="text/css">
    <LINK href="css/twitter.css" rel="stylesheet" type="text/css">
    <script src="twitter/script.js"></script>
</head>
<body onload="process()">
	<div id="container">
		<div id="titleBar"><?php include 'templates/titlebar.html' ?></div>
		
		<div id='nav'><?php include 'templates/nav.php' ?></div>
		<div id="main"><?php include 'templates/main.php'?></div>

		<div id="sideBar">
			<div id="recent"><?php include 'templates/recents.php' ?></div>
            <div id="social">
                
            </div>
		</div>
	</div>


</body>
</html>