<!-- 
    Date : 22-10-2021
   I Yagna Parekh  000846481 certify that this work is my original 
   and has not been shared to anyone.
-->


<!DOCTYPE html>

<?php



    include "connect.php";
    

    $command = "SELECT wumpusRow, wumpusColumn FROM wumpuses  WHERE wumpusRow=? AND wumpusColumn=?";
    $stmt = $dbh->prepare($command);
    $param = [ filter_input(INPUT_GET, "row", FILTER_VALIDATE_INT), filter_input(INPUT_GET, "column", FILTER_VALIDATE_INT) ];
    $success = $stmt->execute($param);
    $paramsok = $stmt->fetch();

    if ($paramsok)
    {
        $wumpus_found = true;
    }
    else
    {
        $wumpus_found = false;
    }

?>
<html>
<head>
    <title> Wumpus Result </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/wumpus.css">
</head>
<body>

    <?php
        if($paramsok)
        {
            echo "YOU WIN!";
            $src = "win.jpg";
        }
        else
        {
            echo "YOU LOSE.......<br/>";
            $src = "sad.png";
        }
    ?>
    <img src = "<?php echo $src ?>">
        <form action = "save.php" method = "post"> <br/>

        <input type = "email"  name = "emailAddress" placeholder = "example@gmail.com" required>

        <input type = "hidden" name = "wumpus_found" value = "<?php $wumpus_found ?>" >

        <input type = "submit" value = "Submit">
    </form>
</body>
</html>