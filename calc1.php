<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
                             <link href="style.css" rel="stylesheet" type="text/css" />
                                        <title>Temple Siege</title>
                                        </head>

                                        <body>
                                        <div id="container">
                                                <div id="header"></div>
                                                        <div id="menu">

                                                                </div>

                                                                <div id="main"><br />
                                                                        <div id="content">

                                                                                <div id="left">

                                                                                        <p>
                                                                                        <?php
//Calc1.php just scans the matches table for new players to add to the players database.
// Connect to MySQL
                                                                                        include 'config.php';
$link = mysql_connect ($hostname, $username, $password);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("iccup_reranked") or die (mysql_error());
$select_maxid = mysql_query("SELECT MAX(match_id) FROM match");
$row1 = mysql_fetch_array($select_maxid, MYSQL_BOTH);
$max_id = $row1[0];
echo "Total Matches: " . $max_id . "<br />";

//Cycles through each player in the matches table
for($i = 1; $i <= $max_id; $i++)
{
    $grabMatchRow = mysql_query("SELECT * FROM matches WHERE match_id = '$i'");
    $matchRow = mysql_fetch_array($grabMatchRow, MYSQL_BOTH);
    $table = mysql_real_escape_string($matchRow[1]);
    $table2 = mysql_real_escape_string($matchRow[2]);
    $mapPlayed = $matchRow[5];
    $ratingPeriod = 1;
    $sql= "SELECT * FROM players WHERE name = '$table'";
    $sql2= "SELECT * FROM players WHERE name = '$table2'";
    $select_maxPlayerid = mysql_query("SELECT MAX(ID) FROM players");
    $row1 = mysql_fetch_array($select_maxPlayerid, MYSQL_BOTH);
    $max_Playerid = $row1[0];
    echo "Max ID: " . $max_Playerid . "<br />";
    $newMaxID = $max_Playerid + 1;
    $result=@mysql_query($sql);
    $result2=@mysql_query($sql2);
//if the player doesn't exist, add them to the players table.
    if (!mysql_fetch_row($result))
    {
        $select_maxPlayerid = mysql_query("SELECT MAX(ID) FROM players");
        $row1 = mysql_fetch_array($select_maxPlayerid, MYSQL_BOTH);
        $max_Playerid = $row1[0];
        echo "Max ID: " . $max_Playerid . "<br />";
        $newMaxID = $max_Playerid + 1;
        echo $table . "'s table doesn't exist.<br />";
        mysql_query("INSERT INTO players (name, rating, rdeviation, played, won, lost) VALUES ('$table', 1500, 300, 0, 0, 0)") or die(mysql_error());
        echo "Table created!<br />";
    }

    if (!mysql_fetch_row($result2))
    {
        $select_maxPlayerid = mysql_query("SELECT MAX(ID) FROM players");
        $row1 = mysql_fetch_array($select_maxPlayerid, MYSQL_BOTH);
        $max_Playerid = $row1[0];
        echo "Max ID: " . $max_Playerid . "<br />";
        $newMaxID = $max_Playerid + 1;
        echo $table2 . "'s table doesn't exist.<br />";
        mysql_query("INSERT INTO players (name, rating, rdeviation, played, won, lost) VALUES ('$table2', 1500, 300, 0, 0, 0)") or die(mysql_error());
        echo "Table created!<br />";
    }

}
mysql_close();
?>
</p>
</div>
<div class="clear"></div>
               </div>

               </div>

               </div>
               </body>
               </html>