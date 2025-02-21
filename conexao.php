<?php
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'twofootball';



try{
    $conexao = new PDO("mysql:host=$server;dbname=$dbname", $username, $password);

}
catch(PDOException $e) {
    echo "Erro conexao: " . $e->getMessage();
  
}
?>