<!-- 
    Date : 22-10-2021
   I Yagna Parekh  000846481 certify that this is my original work
   and has not been shared to anyone.
-->

<?php
    try{
        $dbh = new PDO("mysql:host=localhost;dbname=sa000846481",
                      "root",
                      "");
    } 
    catch(Exception $e) 
    {
        die("ERROR: Couldn't connect. {$e->getMessage()}");
    }
?>