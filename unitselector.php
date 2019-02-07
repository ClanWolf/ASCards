<?php
session_start();
// https://www.php-einfach.de/php-tutorial/php-sessions/

	require('./db.php');
	if (!isset($_SESSION['playerid'])) {
		echo "Not logged in... redirecting.<br>";
		echo "<meta http-equiv='refresh' content='0;url=./login.php'>";
		die();
	}

	// Get data on units from db
	$pid = $_SESSION['playerid'];

	$opt1 = isset($_GET["opt1"]) ? $_GET["opt1"] : "";
	$opt2 = isset($_GET["opt2"]) ? $_GET["opt2"] : "";

	if ($opt1 == true || $opt2 == true) {
		// storing changed options to database
		$sql_update_options = "UPDATE asc_options SET OPTION1=".$opt1.", OPTION2=".$opt2." WHERE playerid = ".$pid;
		$result_update_options = mysqli_query($conn, $sql_update_options);
		echo "<meta http-equiv='refresh' content='0;url=./unitselector.php'>";
		die();
	} else {
		// getting options from database
		$sql_asc_options = "SELECT SQL_NO_CACHE * FROM asc_options where playerid = ".$pid;
		$result_asc_options = mysqli_query($conn, $sql_asc_options);
		if (mysqli_num_rows($result_asc_options) > 0) {
			while($row = mysqli_fetch_assoc($result_asc_options)) {
				$opt1 = $row["option1"];
				$opt2 = $row["option2"];
				$_SESSION['option1'] = $opt1;
				$_SESSION['option2'] = $opt2;
			}
		}
	}
?>

<html lang="en">

<head>
	<title>ClanWolf.net: AplhaStrike Card App (ASCard): Unit selector</title>
	<meta charset="utf-8">
	<meta http-equiv="expires" content="0">
	<meta name="description" content="Cards app for the AlphaStrike TableTop (BattleTech).">
	<meta name="keywords" content="BattleTech, AlphaStrike, Mech">
	<meta name="robots" content="noindex,nofollow">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<!-- <meta name="viewport" content="width=1700px, initial-scale=1.0, user-scalable=no"> -->

	<link rel="manifest" href="./manifest.json">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="./styles/styles.css">
	<link rel="icon" href="./favicon.png" type="image/png">
	<link rel="shortcut icon" href="./images/icon_196x196.png" type="image/png" sizes="196x196">
	<link rel="apple-touch-icon" href="./images/icon_57x57.png" type="image/png" sizes="57x57">
	<link rel="apple-touch-icon" href="./images/icon_72x72.png" type="image/png" sizes="72x72">
	<link rel="apple-touch-icon" href="./images/icon_76x76.png" type="image/png" sizes="76x76">
	<link rel="apple-touch-icon" href="./images/icon_114x114.png" type="image/png" sizes="114x114">
	<link rel="apple-touch-icon" href="./images/icon_120x120.png" type="image/png" sizes="120x120">
	<link rel="apple-touch-icon" href="./images/icon_144x144.png" type="image/png" sizes="144x144">
	<link rel="apple-touch-icon" href="./images/icon_152x152.png" type="image/png" sizes="152x152">
	<link rel="apple-touch-icon" href="./images/icon_180x180.png" type="image/png" sizes="180x180">

	<script type="text/javascript" src="./scripts/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="./scripts/howler.min.js"></script>
	<script type="text/javascript" src="./scripts/cookies.js"></script>

	<style>
		html, body {
			background-image: url('./images/body-bg_2.jpg');
		}
		table {
			margin-left: auto;
			margin-right: auto;
		}
		.box {
			width: 400px;
			height: 200px;
			background-color: #transparent;
			position: fixed;
			margin-left: -200px;
			margin-top: -100px;
			top: 50%;
			left: 50%;
		}
		.options {
			z-index: 3;
			position: absolute;
			vertical-align: middle;
			border-radius: 5px;
			border-style: solid;
			border-width: 3px;
			padding: 25px;
			background: rgba(60,60,60,0.75);
			width: 300px;
			height: 70px;
			top: 80px;
			right: 20px;
			color: #ddd;
			border-color: #aaa;
		}
	</style>
</head>

<body>
	<script>
		$(document).ready(function() {
			$("#cover").hide();
		});

		function changeOption() {
			var na = "";
			var opt1 = 0;
			var opt2 = 0;
			var list = document.getElementsByClassName("bigcheck");
			[].forEach.call(list, function (el1) {
				na = el1.name;
				if (typeof na != 'undefined') {
					if (na.substring(0, 4) == "OPT1") { opt1 = el1.checked }
					if (na.substring(0, 4) == "OPT2") { opt2 = el1.checked }
				}
			})
			var url="./unitselector.php?opt1="+opt1+"&opt2="+opt2;
			// alert (url);
			window.location.href = url;
		}

		function setOptions() {
			var na = "";
			var list = document.getElementsByClassName("bigcheck");
			[].forEach.call(list, function (el1) {
			na = el1.name;
				if (typeof na != 'undefined') {
					if (na.substring(0, 4) == "OPT1") { el1.checked = <?php echo $opt1 ?> }
					if (na.substring(0, 4) == "OPT2") { el1.checked = <?php echo $opt2 ?> }
				}
			})
		}
	</script>

	<div id="cover"></div>

	<div id="header">
		<table style="width: 100%;" cellspacing="0" cellpadding="0">
			<tr>
				<td onclick="location.href='./logout.php'" width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;" nowrap>
					<div><a style="color: #eee;" href="./logout.php"><i class="fa fa-power-off" aria-hidden="true"></i></a></div>
				</td>
				<td onclick="location.href='./unitselector.php'" width="33%" nowrap><div class='mechselect_button_active'><a href='./unitselector.php'>SELECT UNIT</a><br><span style='font-size:16px;'>Choose a unit to play</span></div></td>
				<td onclick="location.href='./createplayer.php'" width="34%" nowrap><div class='mechselect_button_normal'><a href='./createplayer.php'>CREATE PLAYER</a><br><span style='font-size:16px;'>Create a new player</span></div></td>
				<td onclick="location.href='./createunit.php'" width="33%" nowrap><div class='mechselect_button_normal'><a href='./createunit.php'>CREATE UNIT / PILOTS</a><br><span style='font-size:16px;'>Create a new unit and pilot</span></div></td>
			</tr>
		</table>
	</div>

	<table class="box" cellspacing=10 cellpadding=10 border=0px>
		<tr>
			<td onclick="location.href='./unit.php?unit=5'" class='mechselect_button_active'><a href="./unit.php?unit=5">Meldric</a></td>
			<td onclick="location.href='./unit.php?unit=6'" class='mechselect_button_active'><a href="./unit.php?unit=6">Nimrod</a></td>
		</tr>
	</table>

<?php
	if ($pid == $unitplayerid) {
		echo "<div id='player_image'>";
		echo "	<img src='./images/player/".$pimage."' width='65px''>";
		echo "</div>";
	}
?>

	<div class="options">
		<table>
			<tr>
				<td align="left" style="color: #aaa;">
					<label class="bigcheck"><input onchange="changeOption();" type="checkbox" class="bigcheck" name="OPT1" value="yes"/><span class="bigcheck-target"></span></label>&nbsp;&nbsp;
				</td>
				<td align="left" class="datalabel">
					Block other players units
				</td>
			</tr>
			<tr>
				<td align="left" style="color: #aaa;">
					<label class="bigcheck"><input onchange="changeOption();" type="checkbox" class="bigcheck" name="OPT2" value="yes"/><span class="bigcheck-target"></span></label>&nbsp;&nbsp;
				</td>
				<td align="left" class="datalabel">
					Auto crit rolls (tap dice)
				</td>
			</tr>
		</table>
	</div>

	<script>
		setOptions();
	</script>
</body>

</html>
