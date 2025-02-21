<?php

include_once '../config.php';

$sql = "SELECT * FROM localizacao ORDER BY localizacao.nome ASC";
$result = $conn->query($sql);

$sql2 = "SELECT jogadores.idJogador, jogadores.fotoPerfil, jogadores.nome, jogadores.idade, jogadores.numCamisa, jogadores.posicao, clubes.nome AS clube FROM jogadores JOIN contratojogadores ON contratojogadores.idJogador = jogadores.idJogador JOIN clubes ON contratojogadores.idClube = clubes.idClube WHERE contratojogadores.id = ( SELECT MAX(id) FROM contratojogadores WHERE idJogador = jogadores.idJogador ) ORDER BY contratojogadores.id DESC, jogadores.nome;";
$result2 = $conn->query($sql2);

session_start();
if(isset($_SESSION['login'])){

    if($_SESSION['login']){
        $login = true;
        $id = $_SESSION['id'];  
        $sql_usu = "SELECT * FROM usuario WHERE id = $id";
        $res_usu = $conn->query($sql_usu);
        $res_usu->execute();
    
        if($res_usu->rowCount() > 0){
            $reg_usu = $res_usu->fetch(PDO::FETCH_ASSOC);
        }
    }
}else{
    $login = false;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jogadores | TwoFootball</title>
    <link rel="stylesheet" href="styles/desenvolvedores.css">
    <link rel="stylesheet" href="../styles/sidebar.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="icon" href="../imagens/logoNoTitle.png" type="image/png">
</head>

<body>

<nav id="menu" class="menu" style="margin-top: 0px; "  onmouseenter="abrir()" onmouseleave="abrir()">
        <div class="actionbar">
            <div>
                <button id="openMenuSideBar"><img src="../imagens/logoNoTitle.png" width="40px"></button>
                <h3 class="menuText" id="sidebarTitle">TWOFOOTBALL</h3>
                <i class="fas fa-chevron-right" style="margin-left: -5px;"></i>
            </div>
        </div>
        <ul class="optionsBar">
            <li class="menuItem">
                <a href="../index.php" class="menuOption" style="color: black;">
                    <span class="material-symbols-outlined">
                        home
                    </span>
                    <h5 class="menuText">Início</h5>
                </a>
            </li>
            <li class="menuBreak">
                <hr>
            </li>
            <li class="menuItem">
                <a href="../paginas/jogadores.php" class="menuOption" style="color: black;">
                <button id="productManagerBtn" class="menuOption">
                    <span class="material-symbols-outlined">
                        sprint
                    </span>
                    <h5 class="menuText">Jogadores</h5>
                </button>
                </a>
            </li>
            <li class="menuItem">
                <a href="../paginas/clube.php">
                <button id="constantManagerBtn" class="menuOption">
                    <span class="material-symbols-outlined">
                        sports_soccer
                    </span>
                    <h5 class="menuText">Clubes</h5>
                </button>
                </a>
            </li>
            <li class="menuItem">
                <a href="../paginas/tecnico.php">
                <button id="orderManagerBtn" class="menuOption">
                    <span class="material-symbols-outlined">
                        sports
                    </span>
                    <h5 class="menuText">Técnicos</h5>
                </button>
                </a>
            </li>
            <li class="menuItem">
                <a href="../paginas/campeonato.php">
                <button id="tagManagerBtn" class="menuOption">
                    <span class="material-symbols-outlined">
                        emoji_events
                    </span>
                    <h5 class="menuText">Campeonatos</h5>
                </button>
                </a>
            </li>
            <li class="menuItem">
                <a href="../paginas/contratojogadores.php">
                <button id="tagManagerBtn" class="menuOption">
                    <span class="material-symbols-outlined">
                        contract
                    </span>
                    <h5 class="menuText">Contratos | Jogadores</h5>
                </button>
                </a>
            </li>
            <li class="menuItem">
                <a href="../paginas/contratotecnicos.php">
                <button id="tagManagerBtn" class="menuOption">
                    <span class="material-symbols-outlined">
                        contract
                    </span>
                    <h5 class="menuText">Contratos | Técnicos</h5>
                </button>
                </a>
            </li>
            <li class="menuItem">
                <a href="desenvolvedores.php">
                <button id="tagManagerBtn" class="menuOption">
                    <span class="material-symbols-outlined">
                        code
                    </span>
                    <h5 class="menuText">Desenvolvedores</h5>
                </button>
                </a>
            </li>
        </ul>
        <div class="menuUser">
        <?php
            if($login){
                echo '<a href="../usuario/usuario.php">';
                echo '<div>';
                echo '<img src="../imagens/FotoPerfil/'.$reg_usu['fotoPerfil']. '" alt="">';
                echo '</div>
                <h5 id="nomeUsuario" class="Username menuText">'.$reg_usu['nome'].'</h5>
                </a>';
            }else{
                echo '<a href="login.php">
                <div>
                    <img src="../imagens/usuarioNoLogin.png" alt="">
                </div>
                <h5 id="nomeUsuario" class="Username menuText">Fazer Login</h5>
            </a>';
            }
            ?>
        </div>
    </nav>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        const openMenuSideBar = document.getElementById('openMenuSideBar');
        const menu = document.getElementById('menu');
        const menuText = document.querySelectorAll('.menuText');

        function abrir() {
            menu.classList.toggle('open');
            menuText.forEach(function(text, index) {
                setTimeout(() => {
                    text.classList.toggle('open2');
                }, index * 50);
            })
        }
    </script>

    <div id="all">
        <div class="cardDev" style="display: flex;">
            <div id="img">
            <img src="imagensDesenvolvedores/joaopedro.jpg" width="200px" style="border-radius: 100%; margin-right: 15px;">
            </div>
            <div id="text" style="display: block; font-family: 'Poppins';">
            <h2 style="font-weight: bolder; margin-top: 50px;">João Pedro Baradelli Pavan</h2>
            <p style="margin-bottom: 5px;">Programador Front-End em HTML e CSS</p>
            <a href="https://www.facebook.com/joao.baradelli" style="color: blue; font-weight: bolder; font-size: 28px; text-decoration: none;" target="_blank">Facebook</a>
            </div>
        </div>
        <div class="cardDev" style="display: flex;">
            <div id="img">
            <img src="imagensDesenvolvedores/jose.jpg" width="200px" style="border-radius: 100%; margin-right: 15px;">
            </div>
            <div id="text" style="display: block; font-family: 'Poppins';">
            <h2 style="font-weight: bolder; margin-top: 50px;">José Gabriel Cezário Barreto</h2>
            <p style="margin-bottom: 5px;">Programador Front-End em HTML e CSS</p>
            <a href="https://instagram.com/ze_gabriel.c?utm_source=qr&igshid=ZTM4ZDRiNzUwMw==" style="color: purple; font-weight: bolder; font-size: 28px; text-decoration: none;" target="_blank">Instagram</a>
            </div>
        </div>
        <div class="cardDev" style="display: flex;">
            <div id="img">
            <img src="imagensDesenvolvedores/bruno.jpg" width="200px" style="border-radius: 100%; margin-right: 15px;">
            </div>
            <div id="text" style="display: block; font-family: 'Poppins';">
            <h2 style="font-weight: bolder; margin-top: 50px;">Bruno Ribeiro da Silva</h2>
            <p style="margin-bottom: 5px;">Programador Back-End PHP/Kodular App</p>
            <a href="https://x.com/Brunorib16?t=Xp2qDxhkBXCBRmKOVzAVpQ&s=08" style="color: cyan; font-weight: bolder; font-size: 28px; text-decoration: none;" target="_blank">Twitter</a>
            </div>
        </div>
        <div class="cardDev" style="display: flex;">
            <div id="img">
            <img src="imagensDesenvolvedores/samuel.jpg" width="200px" style="border-radius: 100%; margin-right: 15px;">
            </div>
            <div id="text" style="display: block; font-family: 'Poppins';">
            <h2 style="font-weight: bolder; margin-top: 50px;">Samuel Santos Oliveira</h2>
            <p style="margin-bottom: 5px;">Programador Front-End no App Kodular</p>
            <a href="https://www.youtube.com/channel/UCgZtfKpHIFKl9t1XzjOtjKQ" style="color: red; font-weight: bolder; font-size: 28px; text-decoration: none;" target="_blank">Youtube</a>
            </div>
        </div>
    </div>

</body>

</html>