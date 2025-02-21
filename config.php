<?php

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'twofootball';




    try{
        $conn = new PDO("mysql:host=$host; dbname=$dbname", $username, $password);
    }
    catch(PDOException $e){
        echo "Erro na conexão: " . $e->getMessage();
    }

?>