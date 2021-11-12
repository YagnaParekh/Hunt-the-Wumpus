<!-- 
    Date : 22-10-2021
   I Yagna Parekh  000846481 certify that this work is my original 
   and has not been shared to anyone.
-->



<!DOCTYPE html>
<?php
    include "connect.php";

    $emailAddress = filter_input(INPUT_POST, "emailAddress", FILTER_VALIDATE_EMAIL);
    $wumpus_found = filter_input(INPUT_POST, "wumpus_found", FILTER_VALIDATE_INT);

    if($emailAddress === false && $emailAddress === null && 
       $wumpus_found === false && $wumpus_found === null)
    {
       echo "Error.......";
    }
    $command = "SELECT * FROM players WHERE emailAddress = ?";
    $stmt = $dbh->prepare($command);
    $param = [$emailAddress];
    $success = $stmt->execute($param);
        if($success && $row = $stmt->fetch())
        {
            $command = "UPDATE players SET wins=?, losses=?, dateLastPlayed=CURDATE() WHERE emailAddress=?";
            $stmt = $dbh->prepare($command);
            $win_number = $row['wins'];
            $lose_number = $row['losses'];

            if($wumpus_found)
            {
                $win_number++;
            }
            else  
            {
                $lose_number++;
            }
            $param = [$win_number, $lose_number, $emailAddress];
            $success = $stmt->execute($param);

        }
        else
        {
            $command = "INSERT INTO players (emailAddress, wins, losses, dateLastPlayed) VALUES (?,?,?,CURDATE())";
            $stmt = $dbh->prepare($command);

            if($wumpus_found)
            {
                $win_number = 1;
                $lose_number = 0;
            }
            else
            {
                $win_number = 0;
                $lose_number = 1;
            }
            $param = [filter_input(INPUT_POST, "emailAddress", FILTER_VALIDATE_EMAIL), $win_number, $lose_number];
            $success = $stmt->execute($param);
        }
        $command = "SELECT * FROM players";
        $stmt = $dbh->prepare($command);
        $success = $stmt->execute();
        $players = $stmt->fetchAll();
?>
<html>
<head>
<title> Save Data of Players </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/wumpus.css">
</head>
<body>


    <div id = "button">
        <button onclick = "location.href = 'index.php'"> PLAY AGAIN </button>
    </div>

    <table>
        <tr>
            <td> TOP 10 PLAYERS </td>
        </tr>

        <tr>
            <td> Email Address </td>
            <td> Total Wins </td>
            <td> Total Losses </td>
            <td> Date Last Played </td>
        </tr>

        <?php foreach ($players as $row) { ?>
            <tr>
                <td><?php echo $row['emailAddress']; ?></td>
                <td><?php echo $row['wins']; ?></td>
                <td><?php echo $row['losses']; ?></td>
                <td><?php echo $row['dateLastPlayed']; ?></td>
            </tr>
            <?php } ?>
    </table>
</body>
</html>