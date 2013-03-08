<?php
include 'simple_html_dom.php';
set_time_limit(720);
// Create DOM from URL or file
//Eventually replace with a URL finder to cycle through all the matches. For now, just testing on one page.
//http://www.iccup.com/starcraft/details/' . $i . '.html
$con = mysql_connect ("TOP","SEKRIT","INFO");
		if (!$con) { die('Could not connect: ' . mysql_error());   }
		mysql_select_db("jack_iccup_ranking", $con);
		$result = mysql_query("SELECT * FROM matches ORDER BY id DESC"); //sorting by ID to find the highest ID
		if (!$result) { die('Could not result: ' . mysql_error());   }
		$row = mysql_fetch_array($result);
		$result2 = mysql_query("SELECT * FROM scanned ORDER BY id DESC"); //sorting by ID to find the highest ID
		if (!$result2) { die('Could not result: ' . mysql_error());   }
		$row2 = mysql_fetch_array($result2);
function url_exists($url){
$url_headers = @get_headers($url);
if($url_headers[0] != 'HTTP/1.1 200') {
    return false;
}


else {
    return true;
}
}
$highestID = $row2['id']; //Grab the highest ID, so that we can make our new post have that + 1
$newScanID = $highestID + 1;
$i=$newScanID;
while($html = file_get_html('http://www.iccup.com/starcraft/details/' . $i . '.html')){
$html = file_get_html('http://www.iccup.com/starcraft/details/' . $i . '.html');
		$result = mysql_query("SELECT * FROM matches ORDER BY id DESC"); //sorting by ID to find the highest ID
		if (!$result) { die('Could not result: ' . mysql_error());   }
		$row = mysql_fetch_array($result);
		$highestID = $row['id']; //Grab the highest ID, so that we can make our new post have that + 1
		$newID = $highestID + 1;

		mysql_query("INSERT INTO scanned VALUES ('$newScanID')");
		$result3 = mysql_query("SELECT * FROM scanned ORDER BY id DESC"); //sorting by ID to find the highest ID
		if (!$result3) { die('Could not result: ' . mysql_error());   }
		$row3 = mysql_fetch_array($result3);
$highestID = $row3['id']; //Grab the highest ID, so that we can make our new post have that + 1
$newScanID = $highestID + 1;	
// Find all <div> which attribute id=foo
$findRightDiv = $html->find('div[class=pg-right]'); 
$findPlayerNames = $findRightDiv[0]->find('a[class=profile-view-link]');
if (!isset($findPlayerNames[1])){

}
else {
$player1name = $findPlayerNames[0]->innertext;
$findMapNameT = $html->find('a[href="#"]');
$findMapName = $findMapNameT[0]->innertext;
$findRaces = $findRightDiv[0]->find('div[class=field2]');
if(strpos($findRaces[0], 'Terran')){
$player1race = "Terran";
}
elseif(strpos($findRaces[0], 'Zerg')){
$player1race = "Zerg";
}
elseif(strpos($findRaces[0], 'Protoss')){
$player1race = "Protoss";
}
if(strpos($findRaces[1], 'Terran')){
$player2race = "Terran";
}
elseif(strpos($findRaces[1], 'Zerg')){
$player2race = "Zerg";
}
elseif(strpos($findRaces[1], 'Protoss')){
$player2race = "Protoss";
}


	$player2name = $findPlayerNames[1]->innertext;
if(strpos($findMapName, '| iCCup |') !== FALSE){
	if (isset($findPlayerNames[2])){
	}
	else {
	//$findPlayerNames[0] = first player, [1] = second player.
	//Now we find the winner, through the points. But need to be careful of +0 TT.
	$findWinner = $findRightDiv[0]->find('b');
	if (stripos($findWinner[0], "+0") !== false) {
		mysql_query("INSERT INTO matches VALUES ('$newID', '$player1name', '$player2name', '$player2name', CURRENT_TIMESTAMP, '$findMapName', '$player1race', '$player2race', '$i')");
		}
	elseif (stripos($findWinner[0], "-") !== false) {
		mysql_query("INSERT INTO matches VALUES ('$newID', '$player1name', '$player2name', '$player2name', CURRENT_TIMESTAMP, '$findMapName', '$player1race', '$player2race', '$i' )");
		}
		else {;
		mysql_query("INSERT INTO matches VALUES ('$newID', '$player1name', '$player2name', '$player1name', CURRENT_TIMESTAMP, '$findMapName', '$player1race', '$player2race', '$i' )");
			}
		}
	
}
}

$i++;
}
if(!url_exists('http://www.iccup.com/starcraft/details/' . $i . '.html')){

}
?>