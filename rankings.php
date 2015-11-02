<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
                             <link href="iccup_style.css" rel="stylesheet" type="text/css" />
                                        <title>iCCup Ranks!</title>
                                        </head>

                                        <body>
                                        <div id="container">
                                                <div id="header"></div>
                                                        <div id="menu">
                                                                <h1>Rankings</h1>
                                                                </div>

                                                                <div id="main"><br />
                                                                        <div id="content">

                                                                                <div id="left">
                                                                                        <p><b>Now updating, it will catch up in a few hours (around 12 at my estimate). Next planned is to add some more statistics.</b></p>
                                                                                            <p>Welcome to Birdie's Accurate iCCup Ladder Rankings! After seeing how inaccurate the iCCup ladder ranking system is, I decided to try my hand at copying all the information off the iCCup website and re-ranking it using
                                                                                            the <a href="http://en.wikipedia.org/wiki/Glicko_rating_system">Glicko 2</a> ranking system, which is far more accurate. You can consider it an ELO-style ranking system, if you prefer. Players are given a points ranking based on
                                                                                            the system's guess at where their skill is, and an accuracy rating (currently hidden) which represents how confident the system is in the player's points being accurate. In the future I may add more cool stuff like ranking history,
                                                                                            and so on. But for now I think this is adequate. </p>

                                                                                            <p>Please note that there may be bugs, such as matches not being added to the database or ranked. In addition, it doesn't update immediately so you will have to be patient in waiting for your ranking to update. Finally,
                                                                                            note that the system is NOT the same as Fish server's ranking system, and the points bear no relation to Fish. </p>

                                                                                            <p>Oh and one more thing, the Temple Siege site is unrelated to the iCCup ranking system. I may move the ranking elsewhere but for now we're piggy backing off the site, as I'm also one of the developers of that map (A SCII MOBA).</p>
                                                                                            <br />
                                                                                            <p>
                                                                                            <table id="rankings">
                                                                                            <tr>
                                                                                            <th>Pos</th>
                                                                                            <th>Player</th>
                                                                                            <th>Points</th>
                                                                                            <th>Played</th>
                                                                                            <th>Won</th>
                                                                                            <th>Lost</th>
                                                                                            </tr>
                                                                                            <ol>
                                                                                            <?php
                                                                                            include 'config.php';
                                                                                            $con = mysql_connect ($hostname, $username, $password);
                                                                                            //mysql_query($con);
                                                                                        if (!$con) { die('Could not connect: ' . mysql_error());   }

                                                                                            mysql_select_db("iccup_reranked", $con);
                                                                                            $result = mysql_query("SELECT * FROM player ORDER BY rating DESC");
                                                                                            if (!$result) { die('
                                                                                        Could not result: ' . mysql_error());   }
                                                                                            $i=0;
                                                                                            while($row = mysql_fetch_array($result))
                                                                                        {
                                                                                            $i = $i + 1;
                                                                                            echo "<tr>" . "<td>" . $i . "</td> " . "<td><a name=" . $row['
                                                                                            name'] .">" . "<a href=\"http://www.iccup.com/starcraft/gamingprofile/" . $row['name'] . ".html\">" . $row['name'] . "</td><td>" . $row['rating'] . " &plusmn; " . $row['rdeviation'] . "</td><td>" . $row['played'] . "</td><td>" . $row['won'] . "</td><td>" . $row['lost'] . "</tr>";

                                                                                        }
                                                                                            mysql_free_result($result);
                                                                                            mysql_close();
                                                                                            ?>
                                                                                            </ol>
                                                                                            </table>
                                                                                            </p>
                                                                                            </div>
                                                                                            <div id="right">
                                                                                            <div class="member">

                                                                                            </div>



                                                                                            </div>
                                                                                            <div class="clear"></div>
                                                                                            </div>

                                                                                            </div>
                                                                                            <?php echo file_get_contents("footer.html"); ?>
                                                                                            </div>
                                                                                            </body>
                                                                                            </html>