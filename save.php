<?php
	require_once('./db.php');

	$index = $_GET["index"];
	$h     = $_GET["h"];
	$a     = $_GET["a"];
	$s     = $_GET["s"];
	$e     = $_GET["e"];
	$fc    = $_GET["fc"];
	$mp    = $_GET["mp"];
	$w     = $_GET["w"];

	echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>";

	if (!empty($index)) {
		echo "SAVING MECH DATA...<br>";

		echo $index;
		echo $h;
		echo $a;
		echo $s;
		echo $e;
		echo $fc;
		echo $mp;
		echo $w;
		echo "<br>";

		$sql = "UPDATE clanwolf.asc_mechstatus SET heat=".$h.",armor=".$a.",structure=".$s.",crit_engine=".$e.",crit_fc=".$fc.",crit_mp=".$mp.",crit_weapons=".$w." WHERE mechid=".$index;
		echo "UPDATE clanwolf.asc_mechstatus<br>SET heat=".$h.",armor=".$a.",structure=".$s.",crit_engine=".$e.",crit_fc=".$fc.",crit_mp=".$mp.",crit_weapons=".$w." WHERE mechid=".$index;

		// if (mysqli_query($conn, $sql)) {
			// echo "<br>";
			// echo "Record updated successfully";
		// } else {
			// echo "<br>";
			// echo "Error updating record: " . mysqli_error($conn);
		// }
	} else {
		echo "WAITING FOR SAVE OPERATION...<br>";
	}

	echo "</p>";
?>