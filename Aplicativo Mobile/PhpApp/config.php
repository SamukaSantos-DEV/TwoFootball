<?php

    $host = 'localhost';
    $username = 'id21537612_twofootballuser';
    $password = 'JJBSFTbd23!';
    $dbname = 'id21537612_twofootball';

    try{
        $conn = new PDO("mysql:host=$host; dbname=$dbname", $username, $password);
    }
    catch(PDOException $e){
        echo "Erro na conexão: " . $e->getMessage();
    }

?>