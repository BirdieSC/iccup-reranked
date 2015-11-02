<?php
include 'Glicko2.php';
$Bob = new Glicko2Player();

//Connect to the SQL server
mysql_connect ("TOP","SEKRIT","INFO") or die(mysql_error());
//Connect to the database
mysql_select_db("iccup_reranked") or die (mysql_error());
$select_maxid = mysql_query("SELECT MAX(match_ID) FROM matches");
$row1 = mysql_fetch_array($select_maxid, MYSQL_BOTH);
$max_id = $row1[0];
echo "Max ID: " . $max_id . "<br />";
/*
//Reset code, uncomment if you want to manually reset player list without having to run calc1.php again. To be honest, not really necessary but I had it as part of the old code I originally copied from.
for($i = 1; $i <= $max_id; $i++)
	{

	$pNameGrab = mysql_query("SELECT * FROM players WHERE id = '$i'") or die(mysql_error());
	$pName = mysql_fetch_row($pNameGrab) or die(mysql_error());

	//Initialize every player's ELO as 1500, rdeviation as 300
	$select_maxid2 = mysql_query("SELECT MAX(ID) FROM players");
	$row2 = mysql_fetch_array($select_maxid2, MYSQL_BOTH);
	$max_id2 = $row2[0];
	mysql_query("UPDATE players SET elo=1500 WHERE name = '$pName[1]'");
	mysql_query("UPDATE players SET rdeviation=300 WHERE name = '$pName[1]'");
	mysql_query("UPDATE players SET won=0 WHERE name = '$pName[1]'");
	mysql_query("UPDATE players SET played=0 WHERE name = '$pName[1]'");
	mysql_query("UPDATE players SET lost=0 WHERE name = '$pName[1]'");

	}
	*/
$rankedGrab = mysql_query("SELECT MAX(ID) FROM ranked") or die(mysql_error());
$ranked = mysql_fetch_row($rankedGrab) or die(mysql_error());
echo $ranked[0];
echo "Reset done!<br />"; //Only if you uncomment the above code xD
for($l = $ranked[0]; $l <= $max_id; $l++) //Cycles through unchecked matches and modifies player points based on the outcome. Changed the table/row called ranked to 1 to reset this process (first empty the players table).
{

    $matchGrab = mysql_query("SELECT * FROM matches WHERE id = '$ranked[0]'") or die(mysql_error());

    $match = mysql_fetch_row($matchGrab);
    $newRanked = $ranked[0] + 1;
    $rankedGrab = mysql_query("SELECT MAX(ID) FROM ranked") or die(mysql_error());
    $ranked = mysql_fetch_row($rankedGrab) or die(mysql_error());
    mysql_query("UPDATE ranked SET id = '$newRanked' WHERE lastRanked = 1"); //This ranked table is just one row used to store last ranked matches, increments. Could use a text file or anything really,
    //would be possible to do it just by mysql but I was lazy.
    $rankedGrab = mysql_query("SELECT MAX(ID) FROM ranked") or die(mysql_error());
    $ranked = mysql_fetch_row($rankedGrab) or die(mysql_error());
    if (!$match) { //If that row is not found, then it's a deleted row, so skip to the next row.
        echo "Duplicate skipped (entry already deleted).<br />";
        continue;
    }
    else {

        //if  player 1 won the match, check it
        if($match[3] == $match[1])
        {
            $pNameGrab2 = mysql_query("SELECT * FROM players WHERE name = '$match[1]'") or die(mysql_error());
            $pName2 = mysql_fetch_row($pNameGrab2) or die(mysql_error());
            $p1CurrentScore = mysql_query("SELECT * FROM players WHERE name = '$match[1]'") or die(mysql_error());
            $p1CurrentScoreGrab = mysql_fetch_row($p1CurrentScore) or die(mysql_error());
            $p2CurrentScore = mysql_query("SELECT * FROM players WHERE name = '$match[2]'") or die(mysql_error());
            $p2CurrentScoreGrab = mysql_fetch_row($p2CurrentScore) or die(mysql_error());
            $opponentRowGrab = mysql_query("SELECT * FROM players WHERE name = '$match[2]'") or die(mysql_error());
            $opponentRow = mysql_fetch_row($opponentRowGrab) or die(mysql_error());
            $player = new Glicko2player($p1CurrentScoreGrab[2], $p1CurrentScoreGrab[6]);
            $opponent = new Glicko2player($p2CurrentScoreGrab[2], $p2CurrentScoreGrab[6]);
            $player->AddWin($opponent);
            $opponent->AddLoss($player);
            $player->Update();
            $opponent->Update();
            $newELO = $player->rating;
            $newOpponentELO = $opponent->rating;
            $newRdeviation = $player->rd;
            $newOpponentRdeviation = $opponent->rd;
            $newPlayed = $pName2[3] + 1;
            $newOpponentPlayed = $opponentRow[3] + 1;
            $newWon = $pName2[4] + 1;
            $newOpponentLost = $opponentRow[5] + 1;
            mysql_query("UPDATE players SET elo = '$newELO' WHERE name = '$match[1]'");
            mysql_query("UPDATE players SET elo = '$newOpponentELO' WHERE name = '$match[2]'");
            mysql_query("UPDATE players SET rdeviation = '$newRdeviation' WHERE name = '$match[1]'");
            mysql_query("UPDATE players SET rdeviation = '$newOpponentRdeviation' WHERE name = '$match[2]'");
            mysql_query("UPDATE players SET played = '$newPlayed' WHERE name = '$match[1]'");
            mysql_query("UPDATE players SET played = '$newOpponentPlayed' WHERE name = '$match[2]'");
            mysql_query("UPDATE players SET won = '$newWon' WHERE name = '$match[1]'");
            mysql_query("UPDATE players SET lost = '$newOpponentLost' WHERE name = '$match[2]'");
            echo $match[1] . "'s new ELO: " . $newELO  . "<br />";
            echo $match[2] . "'s new ELO: " . $newOpponentELO  . "<br />";
        }
        //if player 2 won it
        elseif($match[3] == $match[2]) {
            $pNameGrab3 = mysql_query("SELECT * FROM players WHERE name = '$match[2]'") or die(mysql_error());
            $pName3 = mysql_fetch_row($pNameGrab3) or die(mysql_error());
            $p1CurrentScore = mysql_query("SELECT * FROM players WHERE name = '$match[2]'") or die(mysql_error());
            $p1CurrentScoreGrab = mysql_fetch_row($p1CurrentScore) or die(mysql_error());
            $p2CurrentScore = mysql_query("SELECT * FROM players WHERE name = '$match[1]'") or die(mysql_error());
            $p2CurrentScoreGrab = mysql_fetch_row($p2CurrentScore) or die(mysql_error());
            $opponentRowGrab = mysql_query("SELECT * FROM players WHERE name = '$match[1]'") or die(mysql_error());
            $opponentRow = mysql_fetch_row($opponentRowGrab) or die(mysql_error());
            $player = new Glicko2player($p1CurrentScoreGrab[2], $p1CurrentScoreGrab[6]);
            $opponent = new Glicko2player($p2CurrentScoreGrab[2], $p2CurrentScoreGrab[6]);
            $player->AddWin($opponent);
            $opponent->AddLoss($player);
            $player->Update();
            $opponent->Update();
            $newELO = $player->rating;
            $newOpponentELO = $opponent->rating;
            $newRdeviation = $player->rd;
            $newOpponentRdeviation = $opponent->rd;
            $newPlayed = $pName3[3] + 1;
            $newOpponentPlayed = $opponentRow[3] + 1;
            $newWon = $pName3[4] + 1;
            $newOpponentLost = $opponentRow[5] + 1;
            mysql_query("UPDATE players SET elo = '$newELO' WHERE name = '$match[2]'");
            mysql_query("UPDATE players SET elo = '$newOpponentELO' WHERE name = '$match[1]'");
            mysql_query("UPDATE players SET rdeviation = '$newRdeviation' WHERE name = '$match[2]'");
            mysql_query("UPDATE players SET rdeviation = '$newOpponentRdeviation' WHERE name = '$match[1]'");
            mysql_query("UPDATE players SET played = '$newPlayed' WHERE name = '$match[2]'");
            mysql_query("UPDATE players SET played = '$newOpponentPlayed' WHERE name = '$match[1]'");
            mysql_query("UPDATE players SET won = '$newWon' WHERE name = '$match[2]'");
            mysql_query("UPDATE players SET lost = '$newOpponentLost' WHERE name = '$match[1]'");
            echo $match[2] . "'s new ELO: " . $newELO  . "<br />";
            echo $match[1] . "'s new ELO: " . $newOpponentELO  . "<br />";
        }


    }
}
//This code I basically copied from the internet, to prevent duplicate matches. Cron jobs are used to run calc1 at 50 past the hour, calculate at 55 past the hour, and then every 30 minutes
//iccup_ranking_get.php is run. Normally it'll reach a timeout before the next scheduled run of iccup_ranking_get.php, but sometimes it bugs (I even added a maximum time! TT) so the script runs twice at once.
//So duplicate matches get put in, but this code removes them.
$query="SELECT DISTINCT scanID FROM matches
       GROUP BY scanID HAVING count(*)>1";

$result=mysql_query($query);

while($row = mysql_fetch_array($result)) {

    $sql="SELECT id FROM matches WHERE
         scanID='".$row['scanID']."' ORDER BY id";

    $res=mysql_query($sql);
    $rowd=mysql_fetch_array($res);
    $count = @mysql_num_rows($res) - 1;

    $delsql="DELETE FROM matches WHERE
            id='".$rowd['id']."' LIMIT ".$count;

    mysql_query($delsql);
}




?>