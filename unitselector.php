<?php

echo "select unit";

?>

<html>

<head>
	<link rel="stylesheet" href="https://www.clanwolf.net/ASCard/styles.css" type="text/css">
	<link rel="icon" href="https://www.clanwolf.net/ASCard/favicon.png" type="image/png">
	<style>
		html, body {
			background-image: url('images/body-bg_2.png');
		}
		table {
			margin-left: auto;
			margin-right: auto;
		}
		.box {
			width: 400px;
			height: 200px;
			background-color :#transparent;
			position: fixed;
			margin-left: -200px;
			margin-top: -100px;
			top: 50%;
			left: 50%;
		}
	</style>
</head>

<body>
	<table class="box" cellspacing=10 cellpadding=10 border=0px>
		<tr>
			<td onclick="location.href='https://www.clanwolf.net/ASCard/index.php?unit=5'" class='mechselect_button_active'><a href="https://www.clanwolf.net/ASCard/index.php?unit=5">Meldric</a></td>
			<td onclick="location.href='https://www.clanwolf.net/ASCard/index.php?unit=6'" class='mechselect_button_active'><a href="https://www.clanwolf.net/ASCard/index.php?unit=6">Nimrod</a></td>
		</tr>
	</table>
</body>

</html>
