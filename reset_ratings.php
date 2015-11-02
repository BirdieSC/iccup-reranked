<?php
	include './includes/config.php';
	$link = mysql_connect ($hostname, $username, $password);
	if (!$link) {
    	die('Could not connect: ' . mysql_error());
	}
	mysql_select_db($database) or die (mysql_error());
	for($i = 1; $i <= $max_id; $i++)
	{
		$pNameGrab = mysql_query("SELECT * FROM player WHERE player_id = '$i'") or die(mysql_error());
		$pName = mysql_fetch_row($pNameGrab) or die(mysql_error());
		//Initialize every player's ELO as 1500, rdeviation as 300	
		$select_maxid2 = mysql_query("SELECT MAX(player_id) FROM player");
		$row2 = mysql_fetch_array($select_maxid2, MYSQL_BOTH);
		$max_id2 = $row2[0];
		mysql_query("UPDATE player SET rating=1500 WHERE name = '$pName[1]'");
		mysql_query("UPDATE player SET rdeviation=300 WHERE name = '$pName[1]'");
		mysql_query("UPDATE player SET won=0 WHERE name = '$pName[1]'");
		mysql_query("UPDATE player SET played=0 WHERE name = '$pName[1]'");
		mysql_query("UPDATE player SET lost=0 WHERE name = '$pName[1]'");
		echo "Reset done!<br />"; //Only if you uncomment the above code xD$ranked[0]
	}

?>