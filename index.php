<?php
require_once('inc/conf.inc.php');

//Calculate how many servers are online
$server_rows = round(count(array_keys($servers_conf)) / 4, 0, PHP_ROUND_HALF_DOWN);
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="/css/serverviewer.css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/ibox.js"></script>
</head>
<body>
</body>
</html>