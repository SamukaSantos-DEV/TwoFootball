<?php

include("config.php");
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "INSERT INTO usuario(id,nome,email,senha,fotoPerfil,clubeFavorito) VALUES('','$nome','$email','$senha','foto',5)";
$result = $conn->prepare($sql);
$result->execute();

?>