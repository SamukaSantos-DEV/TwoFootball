<?php
session_start();
include_once '../config.php';


    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $sql_login = "SELECT * FROM usuario WHERE email = '$email' and senha = '$senha'";
        $res_login = $conn->query($sql_login);
        $res_login->execute();

        if($res_login->rowCount()>0){
            $reg = $res_login->fetch(PDO::FETCH_ASSOC);
            $_SESSION['id'] = $reg['id'];
            $_SESSION['login'] = true;
            header('Location: ../usuario/usuario.php');
        }
    }
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | TwoFootball</title>
    <link rel="stylesheet" href="styles/login.css">
    <link rel="stylesheet" href="../styles/sidebar.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="icon" href="../imagens/logoNoTitle.png" type="image/png">
</head>

<body>

<nav id="menu" class="menu" style="margin-top: 0px;"  onmouseenter="abrir()" onmouseleave="abrir()">
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
            <a href="login.php">
                <div>
                    <img src="../imagens/usuarioNoLogin.png" alt="">
                </div>
                <h5 id="nomeUsuario" class="Username menuText">Fazer Login</h5>
            </a>
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

    <div class="row">
        <div class="col-md-6" id="imgLogin">
            <img src="imagens/login.png" width="370px" style="float: right; border-radius: 35px 0px 0px 35px;">
        </div>
        <div class="col-md-6" id="dadosLogin">
            <form action="" method="post">

                <img src="../imagens/logo.png" width="320px">

                <label for="email">
                    <p class="paragrafo">E-Mail:<strong>*</strong></p>
                </label>
                <input class="cxdt" type="email" placeholder=" Ex: joao.silva@gmail.com" name="email" required />

                <label for="senha">
                    <p class="paragrafo">Senha:<strong>*</strong></p>
                </label>
                <input class="cxdt" type="password" placeholder="Insira sua senha" name="senha" required />

                <input id="salvar" type="submit" value="FAZER LOGIN" name="submit" onclick="sucesso()">
                <h5>Não tem uma conta?<a href="cadastro.php"> Faça Cadastro</a></h5>

                <h2>O Projeto TwoFootball é um projeto escolar sem meio no ramo profissional de sistemas.</h2>

            </form>
        </div>
    </div>


</body>

</html>