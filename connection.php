<?php
    
    include "credentials.php";
    
    //Database connection 
    $connection = new mysqli('localhost', $user, $pw, $db);
    
    //Select all records from out table
    $AllRecords = $connection->prepare("select * from scp");
    $AllRecords->execute();
    $result = $AllRecords->get_result();

?>