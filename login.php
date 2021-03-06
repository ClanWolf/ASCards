<?php
ini_set('session.gc_maxlifetime', 36000);
session_set_cookie_params(36000);
session_start();
// https://www.php-einfach.de/php-tutorial/php-sessions/
	require('./logger.php');
	require('./db.php');
	ini_set("display_errors", 1); error_reporting(E_ALL);
	$login = isset($_GET['login']) ? $_GET['login'] : "";
	$playername = isset($_POST['pn']) ? $_POST['pn'] : "";
	$password = isset($_POST['pw']) ? $_POST['pw'] : "";

	if(!$login == "") {
		if (!($stmt = $conn->prepare("SELECT * FROM asc_player WHERE name = ?"))) {
			echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
		}
		if (!$stmt->bind_param("s", $playername)) {
			echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		}
		if ($stmt->execute()) {
			$res = $stmt->get_result();
			while ($row = $res->fetch_assoc()) {
				if ($row['name'] == $playername) {
					$password_db = $row['password'];
					// var_dump($password_db);
					if (password_verify($password, $password_db)) {
						$_SESSION['playerid'] = $row['playerid'];
						$_SESSION['name'] = $row['name'];
						$_SESSION['email'] = $row['email'];
						$_SESSION['playerimage'] = $row['image'];
						// getting options from database
						$sql_asc_options = "SELECT SQL_NO_CACHE * FROM asc_options where playerid = ".$_SESSION['playerid'];
						$result_asc_options = mysqli_query($conn, $sql_asc_options);
						if (mysqli_num_rows($result_asc_options) > 0) {
							while($row11 = mysqli_fetch_assoc($result_asc_options)) {
								$opt1 = $row11["option1"];
								$opt2 = $row11["option2"];
								$opt3 = $row11["option3"];
								$_SESSION['option1'] = $opt1;
								$_SESSION['option2'] = $opt2;
								$_SESSION['option3'] = $opt3;
							}
						}
   						header("Location: ./gui_select_unit.php");
						die('Login succeeded!<br>');
					} else {
						$errorMessage = "LOGIN FAILED!<br>";
					}
				}
			}
		}
	}
?>

<html lang="en">

<head>
	<title>Login</title>
	<meta charset="utf-8">
	<meta http-equiv="expires" content="0">
	<meta name="description" content="Cards app for the AlphaStrike TableTop (BattleTech).">
	<meta name="keywords" content="BattleTech, AlphaStrike, Mech">
	<meta name="robots" content="noindex,nofollow">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name='viewport' content='user-scalable=0'>

	<link rel="manifest" href="./manifest.json">
	<link rel="stylesheet" href="./styles/styles.css" type="text/css">
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

	<style>
		html, body {
			background-image: url('./images/body-bg_2.jpg');
		}
		table {
			margin-left: auto;
			margin-right: auto;
		}
		input {
			border: 0px;
			padding: 5px;
			margin: 5px;
		}
		.box {
			width: 500px;
			height: 200px;
			background-color: #694007;
			position: fixed;
			margin-left: -250px;
			margin-top: -100px;
			top: 50%;
			left: 50%;
		}
	</style>
</head>

<body>
	<script>
		$(document).ready(function() {
			console.log("Clicking on the form to make the webfont display!");
			document.getElementById("f1").style.visibility = "visible";
			setTimeout(function(){
				// Tried to trick Chrome to apply the right css style to the input fields
				// while auto filling them. No luck...

				//$(window).trigger('resize');
				//$('body').click();
				//document.getElementById('pn').click();
				//document.getElementById('pn').dispatchEvent(new MouseEvent('click', {shiftKey: true}))
				//$("#f1").trigger('focus');
				//var a = $('#pn').val();
				//$("#pn").val($('#pn').val());
				$('#pn').focus();
				//$("#pn").val("sdsd");
				//$('#pw').focus();
  			},1000);
		});
	</script>

	<?php
		if(isset($errorMessage)) {
			echo "<table cellspacing=10 cellpadding=10 border=0px><tr><td><br><br><br>";
			echo "<span style='color:red; font-size: 42px;'>";
			echo $errorMessage;
			echo "</span>";
			echo "</td></tr></table>";
		}
	?>

	<form id="f1" style="visibility:hidden;" action="?login=1" method="post" autocomplete="on">
		<table class="box" cellspacing=10 cellpadding=10 border=0px>
			<tr>
				<td class='mechselect_button_active'>
					<img src="./images/icon_144x144.png">
				</td>
				<td class='mechselect_button_active'>
					<input type="text" size="20" maxlength="80" id="pn" name="pn" required autocomplete="userName"><br>
					<input type="password" size="20"  maxlength="32" id="pw" name="pw" required autocomplete="current-password"><br><br>
					<input type="submit" size="50" style="width:200px" value="LOGIN"><br>
				</td>
			</tr>
		</table>
	</form>

</body>

</html>
